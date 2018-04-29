<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\ContactsRequest;

use App\Lists;
use App\Subscribers;
use App\Groups;

use App\User;

use Illuminate\Database\Eloquent\ModelNotFoundException;

// DebugBar
use Barryvdh\Debugbar\Facade as Debugbar;
use Log;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $params = [
            'id' => $request->id,
        ];

        try {

            $list = Lists::findOrFail($params['id']);

            $sql_where_conditions = [];

            if( $list->client_id != Auth::user()->id ) {
                return redirect('lists');
            }

            $last_group_id = Groups::where('list_id', '=', $params['id'])->orderBy('id', 'desc')->get(['id']);
            
            $groups = Groups::where('list_id', '=', $params['id'])->pluck('name', 'id')->toArray();

            $groups[0] = 'Todos los grupos';

            // Ordenamos los elementos del array por su clave
            ksort($groups);

            $sql_where_conditions[0] = ['lists.client_id', '=', Auth::user()->id];

            if( !empty($request->email) ) {
                $email = $request->old('email');
                array_push( $sql_where_conditions, ['subscribers.email', 'like', '%' . $request->input('email') . '%'] );
            }

            if( !empty($request->name) ) {
                array_push( $sql_where_conditions, ['subscribers.name', 'like', '%' . $request->input('name') . '%'] );
            }

            if( !empty($request->lastname) ) {
                array_push( $sql_where_conditions, ['subscribers.lastname', 'like', '%' . $request->input('lastname') . '%'] );
            }

            if( !empty($request->filter_groups_id) ) {
                array_push( $sql_where_conditions, ['subscribers.group_id', '=', $request->filter_groups_id] );
            }

            if( !empty($request->status) ) {
                array_push( $sql_where_conditions, ['subscribers.status', '=', $request->status] );
            }

            $subscribers = Subscribers::join('groups', 'subscribers.group_id', '=', 'groups.id')
                ->join('lists', 'lists.id', '=', 'groups.list_id')
                ->select('subscribers.*', 'groups.name as group_name')
                ->where($sql_where_conditions)
                ->where('lists.id', '=', $request->id)
                ->orderBy('groups.id', 'asc')
                ->orderBy('subscribers.id', 'desc')
                ->paginate(25);

            return view('contacts.index')
                ->with('list', $list)
                ->with('subscribers', $subscribers)
                ->with('groups', $groups);

        } catch( ModelNotFoundException $err ) {

            return redirect('lists');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ContactsRequest $request)
    {
        $params = [
            'id' => $request->id,
        ];

        try {

            $list = Lists::findOrFail($params['id']);

            if( $list->client_id != Auth::user()->id ) {
                return redirect('lists');
            }

            $groups = Groups::get()->where('list_id', '=', $list->id);

            $subscribers = DB::table('subscribers')
                ->join('groups', 'subscribers.group_id', '=', 'groups.id')
                ->join('lists', 'lists.id', '=', 'groups.list_id')
                ->select('subscribers.*')
                ->where('lists.client_id', '=', Auth::user()->id)
                ->get();

            return view('contacts.create')->with('list', $list)->with('groups', $groups)->with('subscribers', $subscribers);

        } catch( ModelNotFoundException $err ) {

            return redirect('lists');

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // Array que contiene los números de líneas con errores en la caja de texto
        $error_lines = array();

        // Array que contiene la lista de correos de subscriptores ya registrados
        $contacts_emails = array();

        // Array que contiene los errores que pueden surgir con el manejo de archivos
        $file_errors = array();

        // Número de contactos subscritos satisfactoriamente
        $contacts_imported = 0;

        // Array que contiene el request submit producido en el formulario
        $request_submit = '';

        if( isset($request->clients_per_line) ) {

            $request_submit = 'clients_per_line';

            $i = [];

            $clientPerRowCounter = 0;

            $groups = explode(",", $request->groups_id);
            
            foreach($request->email as $email) {

                foreach($groups as $group) {

                    $input = [
                        'email' => $email,
                        'name' => $request->name[$clientPerRowCounter],
                        'lastname' => $request->lastname[$clientPerRowCounter],
                        'group_id' => $group
                    ];

                    if( $email != '' ) {

                        if( $this->check_subscriber_exists( $email, $group ) == 0 ) {
                            
                            Subscribers::create($input);
                            $contacts_imported++;

                        } else {

                            if( !in_array($email, $contacts_emails) ) {
                                array_push( $contacts_emails, $email );
                            }

                        }

                    }
                }

                
                $clientPerRowCounter++;

            }

        } else if ( isset($request->subscribers_per_line) ) {
            
            $request_submit = 'subscribers_per_line';

            $contacts_imported = 0;
            $line_counter = 1;
            $groups_counter = 0;

            $separator = '';

            $groups = explode(",", $request->groups_id_3);

            $subscriber_lines['code'] = explode( "\r\n", $request->contacts_per_line );

            foreach( $groups as $group ) {

                foreach( $subscriber_lines['code'] as $line ) {

                    $input = [
                        'email' => '',
                        'name' => '',
                        'lastname' => '',
                        'group_id' => $group
                    ];

                    if( substr_count($line, ',') == 2  ) {
                        $separator = ',';
                    } else if( strpos($line, ', ') == 2 ) {
                        $separator = ', ';
                    } else {
                        $separator = '///';
                    }

                    if( $separator == ',' || $separator == ', ' || $separator == '///' ) {

                        $line_tmp = explode( $separator, $line );

                        if( $separator == ',' || $separator == ', ') {
                            $input['name'] = $line_tmp[1];
                            $input['lastname'] = $line_tmp[2];
                        } else if( $separator == '///' ) {
                            $input['name'] = null;
                            $input['lastname'] = null;
                        }

                        $input['email'] = $line_tmp[0];
                        $input['group_id'] = $group;

                        if ( $this->validateEmail( $input['email'] ) ) {

                            if( $this->check_subscriber_exists( $input['email'], $group ) == 0 ) {

                                Subscribers::create($input);
                                if( $groups_counter == 0 ) {
                                    $contacts_imported++;
                                }

                            } else {

                                if( ! in_array($input['email'], $contacts_emails) ) {
                                    array_push( $contacts_emails, $input['email'] );
                                }

                            }

                        } else {

                            if( ! in_array($line_counter, $error_lines) && $groups_counter == 0 ) {
                                array_push($error_lines, $line_counter);
                            }

                        }

                    } else {

                        if( ! in_array($line_counter, $error_lines) && $groups_counter == 0 ) {
                            array_push($error_lines, $line_counter);
                        }

                    }

                    $line_counter++;
                }

                $groups_counter++;

            }

        } else if ( isset($request->import_csv) ) {

            $request_submit = 'import_csv';
            $group_counter = 0;

            $line_counter = 2;

            if($request->hasFile('csv_file')) {

                $path = $request->file('csv_file')->getRealPath();
                $extension = $request->file('csv_file')->getClientOriginalExtension();

                $groups = explode(",", $request->groups_id_2);

                if( $extension == 'csv' || $extension == 'xls' ) {

                    if($extension == 'csv') {

                        $f = fopen( $path, 'r' );
                        $line = fgets($f);
                        fclose($f);

                        if( strpos($line, 'email') !== false ) {

                            // set csv delimiter , or ;
                            $line = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line);

                            // obtenemos el delimitador del csv
                            $delimiter_array = array();
                            preg_match("/[^a-zA-Z]/", $line, $delimiter_array);

                            config(['excel.csv.delimiter' => $delimiter_array[0]]);

                        } else {

                            array_push( $file_errors, 'Agrega al inicio del archivo los campos "email, nombre, apellidos"' );

                        }

                    }

                    $data = Excel::load($path, function($reader) {})->get();

                    if( $extension == 'xls' &&  $data->count() == 0) {
                        array_push( $file_errors, 'Agrega al inicio del archivo los campos "email, nombre, apellidos"' );
                    }

                    if(!empty($data) && $data->count()) {

                        foreach( $groups as $group ) {

                            foreach ($data->toArray() as $key => $value) {

                                if(!empty($value)) {

                                    if( $this->validateEmail( $value['email'] )) {

                                        $input = [
                                            'email' => $value['email'],
                                            'name' => $value['nombre'],
                                            'lastname' => $value['apellidos'],
                                            'group_id' => $group
                                        ];

                                        if( $this->check_subscriber_exists( $input['email'], $group ) == 0 ) {

                                            Subscribers::create($input);
                                            if( $group_counter == 0 ) {
                                                $contacts_imported++;
                                            }

                                        } else {

                                            if( ! in_array($input['email'], $contacts_emails) ) {
                                                array_push( $contacts_emails, $input['email'] );
                                            }

                                        }

                                    } else {
                                                
                                        if( ! in_array($line_counter, $error_lines) && $group_counter == 0 ) {
                                            array_push( $error_lines, $line_counter );
                                        }

                                    }
                                }

                                $line_counter++;

                            }

                            $group_counter++;

                        }

                    }

                } else {
                    
                    array_push( $file_errors, 'El archivo que intentas importar no tiene la extensión CSV o XLS' );

                }

            }

        }
        
        $contacts = Subscribers::distinct()->select('email')->whereIn('email', $contacts_emails)->get();

        // Existe un bug en Laravel que no permite que withInputs procese arrays
        // como en el caso de email[], name[] o lastname[]. De este modo se filtra
        // el problema evitando los arrays en caso de que utilicemos los otros
        // modos de importar los contactos

        if( !isset($request->clients_per_line) ) {
            return redirect()->back()
                ->with('contacts', $contacts)
                ->with('contacts_imported', $contacts_imported)
                ->with('error_lines', $error_lines)
                ->with('request_submit', $request_submit)
                ->with('file_errors', $file_errors)
                ->withInput();
        } else {
            return redirect()->back()
                ->with('contacts', $contacts)
                ->with('contacts_imported', $contacts_imported)
                ->with('request_submit', $request_submit);
        }
    }

    /**
     * Acción ejecutada cuando un usuario se suscribe a través de una formulario
     * externo.
     * 
     * @return [type]
     */
    public function form_subscribe( Request $request )
    {
        if( $request->token ) {

            $user = User::where('token', '=', $request->token)->first();

            if ( $user->token == $request->token) {
                
                $input = [
                    'name' => $request->u_name,
                    'lastname' => $request->u_lastname,
                    'email' => $request->u_email,
                    'group_id' => $request->group_id,
                    'status' => 1,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];

                Subscribers::create($input);

            }

        } else {

            return false;

        }

        /*if($request->input('_token')) {
            if ( \Session::getToken() != $request->_token)
            {
              return redirect()->guest('/')
              ->with('global', 'Expired token found. Redirecting to /');
            }
        }

        */

    }

    /**
     * [check_subscriber_exists Comprueba si un subscriptor está dado de alta en un grupo]
     * @param  [string] $email     [Correo del subscriptor]
     * @param  [integer] $group_id [Id del grupo]
     * @return [boolean]           [Retorna verdadero o falso]
     */
    public function check_subscriber_exists( $email, $group_id ) {

        $match = [ 'email' => $email, 'group_id' => $group_id ];

        $subscribers = Subscribers::where($match)->get()->count();
        
        return $subscribers;
    }

    /**
     * Validate that an attribute is a valid e-mail address.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateEmail( $value )
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $subscribers_ids = explode(',', $request->subscribers_ids_delete);
        Subscribers::destroy($subscribers_ids);

        //return redirect('contacts/?id=' . $request->id);
        return redirect()->back();
        
    }

    public function unsubscribe($id, Request $request)
    {
        $subscriber = Subscribers::find($id);
        $subscriber->destroy($id);

        return view('contacts.unsubscribe');
    }
}

<?php

namespace App\Http\Controllers;

use App\DefaultTemplates;
use App\UserTemplates;

use App\Components;
use App\UserComponents;
use App\Taxonomies;

use Auth;
use Illuminate\Support\Facades\Storage;

use Barryvdh\Debugbar\Facade as Debugbar;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Symfony\Component\Debug\Debug;

use Intervention\Image\Facades\Image;

class TemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = DefaultTemplates::select('id', 'featured_picture')->get();

        $user_templates = UserTemplates::where('user_id', '=', Auth::user()->id)->get();

        return view('templates.index')->with('templates', $templates)->with('user_templates', $user_templates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        /** Variable que controla cuando creamos una plantilla o cuando la modificamos. */
        $template_option = 'create';

        /** Variable que guarda el nombre de la plantilla */
        $template_name = '';

        /** Obtenemos los componentes en caso de que el usuario tenga guardada una plantilla previamente */
        $user_templates = UserTemplates::where('user_id', '=', Auth::user()->id)->where('id', '=', $id)->get();

        if( count($user_templates) > 0 ) {

            $template_option = 'modify';

            /** Obtenemos el id de la plantilla por defecto. */
            $default_template = UserTemplates::find($id);
            $default_template_id = $default_template->default_template_id;

            /** Obtenemos el nombre de la plantilla. */
            $templates = UserTemplates::where('id', '=', $id)->select('name')->get();

            foreach($templates as $template) {
                $template_name = $template->name;
            }

            /** Obtenemos la lista de componentes de la plantilla */
            $components = UserComponents::join('taxonomies', 'user_components.id', '=', 'taxonomies.id_component')
                ->where('taxonomies.id_template', '=', $id)
                ->orderBy('taxonomies.order', 'ASC')
                ->get();

        } else {

            $template_option = 'create';

            $default_template_id = $id;

            /** Obtenemos la lista de componentes de la plantilla */
            $components = Components::join('taxonomies', 'components.id', '=', 'taxonomies.id_component')
                ->where('taxonomies.id_template', '=', $id)
                ->orderBy('taxonomies.order', 'ASC')
                ->get();
        }

        /** Obtenemos todos los nombres de los componentes de las plantillas por defecto para procesarlos */
        $component_names = "";
        $total_components = count($components);
        $comp_counter = 1;

        foreach( $components as $component ) {

            if( $comp_counter < $total_components ) {
                $component_names .= $component->name . ',';
            } else {
                $component_names .= $component->name;
            }

            $comp_counter++;
        }

        /** Obtenemos la lista de componentes y sus elementos para guardar la plantilla */
        $user_id = Auth::user()->id;

        return view('templates.edit', compact('user_id', 'component_names', 'template_option', 'template_name', 'id', 'default_template_id'))->with('components', $components);

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
        if( $request->ajax() ) {

            $components = UserComponents::join('taxonomies', 'user_components.id', '=', 'taxonomies.id_component')
                ->where('taxonomies.id_template', '=', $request->id)
                ->select('user_components.*')
                ->get();

            foreach($components as $component) {
                UserComponents::destroy($component->id);
            }

            $taxonomies = Taxonomies::where('id_template', '=', $request->id)->get();

            foreach($taxonomies as $taxonomy) {
                Taxonomies::destroy($taxonomy->id);
            }

            $user_template = UserTemplates::find($request->id);
            $user_template->destroy($user_template->id);
        }

    }

    public function create_date_folders($folder)
    {
        $month = date('m');
        $year = date('Y');

        if( file_exists( storage_path($folder)) === FALSE ) {
            mkdir( storage_path($folder), 0777 );
        }

        if( file_exists( storage_path($folder . '/' . $year) ) === FALSE ) {
            mkdir( storage_path($folder . '/' . $year, 0777) );
        }

        if( file_exists( storage_path($folder . '/' . $year . '/' . $month) ) === FALSE ) {
            mkdir( storage_path($folder . '/' . $year . '/' . $month, 0777) );
        }

        return $folder . '/' . $year . '/' . $month;
    }

    public function upload_image(Request $request)
    {
        $storage_folder = 'uploads/template_users';

        if( $request->ajax() ) {

            /** Nos sirve para obtener el name del input file que maneja la imagen a subir. */
            $file_component = $request->picture_ctrl;
            $base64_component = $request->base64_ctrl;

            //Debugbar::info("file_component: " . $file_component . ", base64: " . $base64_component);

            $picture_filename = uniqid() . "." . $request->file($file_component)->guessExtension();
            $base64_data = $request->{$base64_component};

            $upload_folder = $this->create_date_folders($storage_folder);

            if( file_exists(storage_path($upload_folder)) ) {

                $ifp = fopen( storage_path($upload_folder . '/' . $picture_filename), 'wb');
                $data = explode(',', $base64_data);
                fwrite($ifp, base64_decode($data[1]));
                fclose($ifp);

                return response([
                    'result' => 'http://correo.hormiga/storage/' . $upload_folder . '/' . $picture_filename,
                    'upfolder' => $upload_folder . '/' . $picture_filename,
                    'status' => 'success'
                ]);
            }

        }
    }

    public function imageCrop($folders_and_filename, $x1, $y1, $x2, $y2)
    {
        /** Carpeta donde se subirán las capturas de las plantillas. */
        $template_folder = '/uploads/template_users/';

        /** Redimensionamos la imagen de previsualización de la plantilla */
        Image::make(storage_path($template_folder . $folders_and_filename))->crop($x1, $y1, $x2, $y2)->save(storage_path($template_folder . $folders_and_filename));
    }

    public function imageResize($folders_and_filename, $x, $y)
    {
        /** Carpeta donde se subirán las capturas de las plantillas. */
        $template_folder = '/uploads/template_users/';

        Image::make(storage_path($template_folder . $folders_and_filename))->resize($x, $y, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($template_folder . $folders_and_filename));
    }

    public function saveTemplate($request, $featured_picture_path)
    {
        $input = [
            'user_id' => $request->auth_id,
            'name' => $request->template_name,
            'featured_picture' => $featured_picture_path,
            'default_template_id' => $request->default_template_id,
        ];

        /** Guardamos en la base de datos la nueva plantilla. */
        $user_template = UserTemplates::create($input);

        return $user_template;
    }

    public function saveComponents($request)
    {
        $returnArray = array(
            'names' => array(),
            'first_id_component' => 0
        );

        $component_names = $request->component_names;

        $names_array = explode(',', $component_names);

        $component_margin = 20;
        $component_padding = 20;

        for( $i=0; $i <= (count($names_array)-1); $i++ ) {

            if( $names_array[$i] == 'header' || $names_array[$i] == 'footer' ) {
                $component_margin = 0;
            } else {
                $component_margin = 20;
            }

            if( $names_array[$i] == 'footer' ) {
                $component_padding = 25;
            } else {
                $component_padding = 20;
            }
            
            $component_input = [
                'name' => $names_array[$i],
                'margin' => $component_margin,
                'padding' => $component_padding,
                'content' => $request->{$names_array[$i]}
            ];

            /** Registramos en la base de datos todos los componentes usados en la plantilla. */
            $first_id_component = UserComponents::create($component_input);
        }

        $returnArray['names'] = $names_array;
        $returnArray['first_id_component'] = $first_id_component;

        return $returnArray;
    }

    public function saveTaxonomies($first_id_component, $names_array, $user_template)
    {
        /** Registramos en la base de datos las taxonomias adecuadas. */
        $first_id = $first_id_component->id;
        $first_id = $first_id - ( count($names_array) - 1);

        for( $i=0; $i <= (count($names_array)-1); $i++ ) {

            $taxonomies_input = [
                'id_template' => $user_template->id,
                'order' => $i,
                'id_component' => $first_id
            ];

            $first_id++;

            Taxonomies::create($taxonomies_input);
        }
    }

    public function previewtofile(Request $request)
    {
        if( $request->ajax() ) {

            if( $request->auth_id == Auth::user()->id ) {

                /** Comprobamos si el usuario ya guardó la plantilla anteriormente */
                $user_template = UserTemplates::where('id', '=', $request->template_id)
                    ->where('user_id', '=', $request->auth_id)
                    ->get();

                foreach( $user_template as $templates ) {
                    $template_db_name = $templates->name;
                    $template_featured_picture = $templates->featured_picture;
                    $template_id = $templates->id;
                }

                if( count($user_template) == 0 ) {

                    /** Nombre del archivo de la imagen para la previsualización de la plantilla. */
                    $template_preview_filename = uniqid() . ".png";

                    /** Generamos las carpetas según el mes y el año */
                    $month = date('m');
                    $year = date('Y');

                    $preview_img_folder = storage_path("/uploads/template_users/");

                    if( file_exists($preview_img_folder . $year) === FALSE ) {
                        mkdir( $preview_img_folder . '/' . $year, 0777 );
                        mkdir( $preview_img_folder . '/' . $year . '/' . $month, 0777 );
                    } else {
                        if( file_exists($preview_img_folder . '/' . $year . '/' . $month) === FALSE ) {
                            mkdir( $preview_img_folder . '/' . $year . '/' . $month );
                        }
                    }

                    /** Guardamos la imagen de la plantilla */
                    $ifp = fopen($preview_img_folder . $year . '/' . $month . '/' . $template_preview_filename, 'wb');
                    $data = explode(',', $request->template_preview);
                    fwrite($ifp, base64_decode($data[1]));
                    fclose($ifp);

                    /** Redimensionamos la imagen de previsualización de la plantilla */
                    $this->imageCrop($year . '/' . $month . '/' . $template_preview_filename, 878, 1490, 15, 0);
                    $this->imageCrop($year . '/' . $month . '/' . $template_preview_filename, 847, 1490, 0, 0);
                    $this->imageResize($year . '/' . $month . '/' . $template_preview_filename, 281, null);
                    $this->imageCrop($year . '/' . $month . '/' . $template_preview_filename, 281, 283, 0, 0);

                    /** Guardamos la información de los componentes utilizados en la plantilla */
                    $returnArray = $this->saveComponents($request);

                    /** Guardamos la información general de la plantilla en la base de datos. */
                    $featured_picture_path = $year . '/' . $month . '/' . $template_preview_filename;
                    $user_template = $this->saveTemplate($request, $featured_picture_path);

                    $template_id = $user_template->id;

                    /** Registramos en la base de datos las taxonomias adecuadas. */
                    $this->saveTaxonomies($returnArray['first_id_component'], $returnArray['names'], $user_template);

                } else {

                    /** Modificamos la plantilla */
                    $template_preview_filename = $template_featured_picture;

                    /** Actualizamos la imagen de la plantilla. */
                    if( $request->template_preview != '' ) {
                        $ifp = fopen(storage_path("/uploads/template_users/" . $template_preview_filename), 'wb');
                        $data = explode(',', $request->template_preview);
                        fwrite($ifp, base64_decode($data[1]));
                        fclose($ifp);

                        /** Redimensionamos la imagen de previsualización de la plantilla */
                        $this->imageCrop($template_featured_picture, 878, 1490, 15, 0);
                        $this->imageCrop($template_featured_picture, 847, 1490, 0, 0);
                        $this->imageResize($template_featured_picture, 281, null);
                        $this->imageCrop($template_featured_picture, 281, 283, 0, 0);
                    }

                    /** Modificamos los componentes de la plantilla. */
                    $components = UserComponents::join('taxonomies', 'user_components.id', '=', 'taxonomies.id_component')
                        ->join('user_templates', 'taxonomies.id_template', '=', 'user_templates.id')
                        ->where('user_templates.user_id', '=', Auth::user()->id)
                        ->where('user_templates.id', '=', $template_id)
                        ->select('user_components.*')
                        ->get();

                    foreach( $components as $component ) {
                        UserComponents::where('id', '=', $component->id)
                            ->update(['content' => $request->{$component->name}]);
                    }

                    /** Guardamos la información general de la plantilla. */
                    $templates = UserTemplates::where('id', '=', $template_id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->get();

                    foreach ($templates as $template) {
                        UserTemplates::where('id', '=', $template_id)
                            ->where('user_id', '=', Auth::user()->id)
                            ->update([
                                'name' => $request->template_name,
                            ]);
                    }
                }

                /** Retornamos que el proceso funcionó bien a jQuery */
                return response(['result' => $template_id, 'status' => 'success']);

            } else {

                /** El usuario modificó su id en la plantilla para afectar a otros usuarios. */
                return response(['result' => "El usuario modificó su ID.", 'status' => 'error']);

            }

        }
    }

}

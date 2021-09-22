<?php

if ( ! function_exists('get_json_data')){
    function get_json_data(){

        $is_auth = auth()->check();
        $auth_data = auth()->user();

        $data = [
            'base' => request()->getBasePath(),
            'api_endpoint' => route("api_endpoint"),
            'route' => get_all_routes(),
            'user' => ['auth' => $is_auth, 'data' => $auth_data],
        ];

        return json_encode($data);
    };

}


/**
 * @return array
 *
 * get all registered routes
 */
if ( ! function_exists('get_all_routes')){
    function get_all_routes(){
        $app = app();
        $routes = (array) $app->routes->getRoutes();
        $routeLists = [];
        foreach ($routes as $route){
            $routeLists[str_replace('.', '_', $route->getName())] = asset($route->uri);
        }

        return $routeLists;
    }
}



/**
 * @param string $title
 * @param $model
 * @return string
 */

if ( ! function_exists('unique_slug')) {
	function unique_slug( $title = '', $model = 'Post' ) {
		$slug = \Illuminate\Support\Str::slug( $title );
		if ( $slug === '' ) {
			$string = mb_strtolower( $title, "UTF-8" );;
			$string = preg_replace( "/[\/\.]/", " ", $string );
			$string = preg_replace( "/[\s-]+/", " ", $string );
			$slug   = preg_replace( "/[\s_]/", '-', $string );
		}

		//get unique slug...
		$nSlug = $slug;
		$i     = 0;

		$model = str_replace( ' ', '', "\App\ " . $model );
		while ( ( $model::whereSlug( $nSlug )->count() ) > 0 ) {
			$i ++;
			$nSlug = $slug . '-' . $i;
		}
		if ( $i > 0 ) {
			$newSlug = substr( $nSlug, 0, strlen( $slug ) ) . '-' . $i;
		} else {
			$newSlug = $slug;
		}

		return $newSlug;
	}
}
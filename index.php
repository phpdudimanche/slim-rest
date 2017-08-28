<?php // slim 3.8
require 'vendor/autoload.php';// dependency

//----------------------------------- error handling
$c = new \Slim\Container();

$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write('{"msg":"You are loose ?"}');
    };
};
$c['notAllowedHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write('{"msg":"not this method !"}');
    };
};

$app = new \Slim\App($c);
//------------------------------------

//$app = new \Slim\App();// framework without error handling

//----------------------- Controller (with Model-data and View-json)

// 	curl -i -X POST -H "Accept: application/json" -H "Content-Type: application/json" -d "{\"title\":\"what is it : this thing\",\"description\":\"bug ?\"}" "http://localhost/slim3-rest/"
$app->post('/', function ($request, $response) {
	
	$input = $request->getBody();
	$input=json_decode($input);
	//print($input->title);	// in content html	
	$data=array("msg"=>"C-reate ","title"=>"$input->title");
	$data=json_encode($data);    
	return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->write($data);

});
// Curl -i http://localhost/slim3-rest/54673
$app->get('/{id:\d{1,5}}', function ($request, $response, $args) { // {id} OR {id:[0-9]+} OR \d{1,5}
	
	$data=array("msg"=>"R-etrieve " . $args['id'],"title"=>"issue you wanted to see");
	$data=json_encode($data);
    //print($data);	// in content html	
	return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->write($data);// json header	

});
// curl -X PUT -H "Content-Type: application/json" -d "{\"title\":\"there is really an issue\",\"description\":\"that doesn't work\",\"identification\":\"bug code\",\"resolution\":\"refactoring\",\"status\":\"fixed\"}" "http://localhost/slim3-rest/54673"
$app->put('/{id:\d{1,5}}', function ($request, $response,$args) {
	
	$input = $request->getBody();
	$input=json_decode($input);
	//print($input->title);	// in content html	
	$data=array("msg"=>"U-pdate ". $args['id'],"title"=>"$input->title");
	$data=json_encode($data);    
	return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->write($data);

});
// Curl -i -X DELETE http://localhost/slim3-rest/54673
$app->delete('/{id:\d{1,5}}', function ($request, $response, $args) { // {id} OR {id:[0-9]+} OR \d{1,5}
	
	$data=array("msg"=>"D-elete " . $args['id']);
	$data=json_encode($data);
    //print($data);	// in content html	
	return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->write($data);// json header	

});

$app->run();
?>
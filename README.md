Picture Provider
================================

Store pictures and provider uris for third part.

## Apis:
<span id="apis"></span>

```
Upload a Picture
	POST /{app}
	param
		dir
			in query
			defaut
				/
		content-type
			in header
		content
			in body
			binary
	response
		200
			hash
				in body
				string

Get the Urls of a Picture
	GET /{app}/urls
	param
		hash
			in query
		sizes
			in query
			array
	response
		200
			urls
				in body
				array
				example
					100x100:http://...

Get the origin Url of a Picture
	GET /{app}/url
	param
		hash
			in query
	response
		200
			url
				in body
				string

Get the Content of a Picture
	GET /{app}/content
	param
		hash
			in query
	response
		200
			content
				in body
				binary

Preview the Pictures in the directory
	GET /{app}
	param
		dir
			in query
		sizes
			in query
			array
	response
		200
			list
				in body
				array

Delete Picture
	DELETE /{app}
	param
		path
			in query
	response
		200 Success
		404 No such Picture
		502 503 Failed
	comment
		Only delete Picture relation from the directory, never real delete the picture from storage

Copy Picture
	PATCH /{app}
	param
		path
			in form
		dir
			in form

Move Picture
	PATCH /{app}
	param
		path
			in form
		dir
			in form
```

## Usage

##### 1. Create classes extends `\CatPKT\PictureProvider\AApp` and `\CatPKT\PictureProvider\AStorage`, and a class implements `\CatPKT\PictureProvider\IPicture`.
```php
use CatPKT\PictureProvider as CP;

////////////////////////////////////////////////////////////////

class FooPicture implements IPicture
{
	public function getOriginUrl():string {}
	public function getUrlBySize( int$width, int$height ):string {}
	public function getContent():string {}
	public function getHash():string {}
}

class BarApp extends CP\AApp
{
	protected function createEncryptor():CP\Encryptor {}
}

class BazStorage extends CP\AStorage
{
	protected function findApp( string$appName ):CP\AApp {}                                          // Returns instance of BarApp actually.
	public function list( string$dir ):CP\PictureList {}
	public function get( string$hash ):CP\IPicture {}                                                // Returns instance of FooPicture actually.
	public function store( string$content, string$dir='/', string$contentType=null ):CP\IPicture {}  // Returns instance of FooPicture actually.
	public function delete( string$path ):bool {}
	public function copy( string$path, string$dir ):bool {}
	public function move( string$path, string$dir ):bool {}
}
```

##### 2. Create a instance of `CatPKT\PictureProvider\PictureProvider` and handle the request.
```php
use CatPKT\PictureProvider as CP;
use Symfony\Component\HttpFoundation\Request;

////////////////////////////////////////////////////////////////

$pictureProvider= new CP\PictureProvider(
	new BarStorage();
);

$request= Request::createFromGlobals();

try{
	$response= $pictureProvider->handle( $request );
}
```

##### 3. Catch Exceptions or Errors if exists, and send the response.

```php
catch( \Throwable$e )
{
	#
}

$response->send();
```



## With framework

Ordinarily you whould use a framework to build your picture provider. Just use this library in your controller and route all request in [Apis](#apis) to this controller.
And just return the response and let framework send it.

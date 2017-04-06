Picture Provider
================================

Store pictures and provider uris for third part.

Apis:

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

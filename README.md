
$dom = str_get_html( $str );
or 
$dom = file_get_html( $file_name );

$elems = $dom->find($elem_name);
...

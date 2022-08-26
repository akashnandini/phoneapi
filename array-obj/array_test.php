<!-- Here is the syntax of array_map() function: -->
<!-- array_map ( callable $callback , array $array1 [, array $... ] ) : array -->
<!-- Array Map function is useful when need to modify what gets returns -->

<!-- How array map function works in PHP? -->
<!-- 
Initially to start array function requires a callback function which iterate over each element 
in each array and while interacting it map values from the array. 
Finally it returns an array containing the updated values of first array from the list of provided arrays.
Keep in mind it does not returns the items from second and corresponding arrays.

So basically if you provide more than one array it will be used as arguments for the callback function.
-->

<!-- 
    Examples of using Array Map Function: 
    First let’s create array which is going to have collection of objects and then we will work accordingly.
-->

<?php

class Post
{
    public $title;
    public $body;
    public $author;
    public $published;

    public function __construct($title, $body, $author, $published)
    {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->published = $published;
    }
}

$posts = [
    new Post('Test Post 1', 'Body of post test 1', 'YK', true),
    new Post('Test Post 2', 'Body of post test 2', 'YK', false),
    new Post('Test Post 3', 'Body of post test 3', 'YK', true),
    new Post('Test Post 4', 'Body of post test 4', 'AB', false)
];

$posts = array_map(function ($post) {
    $post->published = true;
    return $post;
}, $posts);

$json_posts = json_encode($posts,JSON_PRETTY_PRINT);
var_dump($json_posts);


/**
 * Define our document structure
 * @var Array
 */

//  external variable


$contract_objects[] = array('cover_page' => array(
    'infile'    => 'common/contract.pdf',
    're_infile' => null,
    'outfile'   => 'pos_1_2.pdf',
    'namespace' => $namespace_config_generator,
    'callback'  => 'generate_cover',
    'data'      => true,
    'pages'     => [1,2],
    're_pages'  => false,
    'name'      => NULL,
    'type'      => '',
));
$contract_objects[] = array('service_req' => array(
    'infile'    => 'common/contract.pdf',
    're_infile' => null,
    'outfile'   => 'pos_3.pdf',
    'namespace' => $namespace_config_generator,
    'callback'  => 'generate_service_req',
    'data'      => false,
    'pages'     => [3],
    're_pages'  => false,
    'name'      => NULL,
    'type'      => '',
));
$contract_objects[] = array('coverage_details' => array(
    'infile'    => 'common/contract.pdf',
    're_infile' => null,
    'outfile'   => 'pos_4.pdf',
    'namespace' => $namespace_config_generator,
    'callback'  => 'generate_coverage_benefits',
    'data'      => true,
    'pages'     => [4],
    're_pages'  => false,
    'name'      => NULL,
    'type'      => '',
));
$contract_objects[] = array('benefits' => array(
    'infile'    => 'common/contract.pdf',
    're_infile' => null,
    'outfile'   => 'pos_5.pdf',
    'namespace' => $namespace_config_generator,
    'callback'  => 'generate_benefits',
    'data'      => false,
    'pages'     => [5],
    're_pages'  => false,
    'name'      => NULL,
    'type'      => '',
));
$contract_objects[] = array('questions' => array(
    'infile'    => 'common/contract.pdf',
    're_infile' => 'common/re_contract.pdf',
    'outfile'   => 'pos_6.pdf',
    'namespace' => $namespace_config_generator,
    'callback'  => 'generate_questions',
    'data'      => false,
    'pages'     => [6],
    're_pages'  => false,
    'name'      => NULL,
    'type'      => '',
));
$contract_objects[] = array('user_agreement' => array(
    'infile'    => 'statecodes/%s.pdf',
    're_infile' => null,
    'outfile'   => 'pos_7_15.pdf',
    'namespace' => $namespace_config_generator,
    'callback'  => 'generate_agreement',
    'data'      => false,
    'pages'     => [7,24], // Modified for dtc/DTC-01012022.pdf
    're_pages'  => [7,24],
    'name'      => NULL,
    'type'      => '',
));


echo "<br>-------------- <br>";
$json_contract_objects = json_encode($contract_objects,JSON_PRETTY_PRINT);
// var_dump($json_contract_objects);

echo "<br>--------CA------ <br>";
$state = "CA";

if($state =="CA")
{
    $contract_objects = array_map(function ($contract_object) {
        $key = array_keys($contract_object);
        $value = array_values($contract_object);
        echo "<br> key => ".$key[0];
        echo "<br> key 2=> ".$value[0]['infile'];
        echo "<br> contract object value =>";
        print_r($contract_object[$key[0]]);

        if($key[0] != 'user_agreement')
        {
            echo "<br>";    
            $value[0]['infile'] = "common_contract1.pdf";
        }
        $contract_object[$key[0]] = $value;
        return $contract_object;
    },$contract_objects);  

    // 
    $contract_objects = array_map(function($cntrct) { print_r($cntrct['user_agreement']); return $cntrct;},$contract_objects);  
}
$json_contract_objects = json_encode($contract_objects,JSON_PRETTY_PRINT);
var_dump($json_contract_objects);
echo "<br>";   
echo "<br>";   
echo "<br>-------------- <br>";


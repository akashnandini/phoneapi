
<?php

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

echo "<br><br> Before Update <br> <br>";
$json_contract_objects = json_encode($contract_objects,JSON_PRETTY_PRINT);
var_dump($json_contract_objects);

$state = "CA";
if($state =="CA")
{
    $contract_objects = array_map(function ($contract_object) {
        $key = array_keys($contract_object);
        $value = array_values($contract_object);
        if($key[0] != 'user_agreement')
        {
            $value[0]['re_infile'] = "previous file ->".$value[0]['infile'];
            $value[0]['infile'] = "common_contract2.pdf";
            $value[0]['namespace'] = "nandini";
            $value[0]['name'] = "heavy tough";
        }
        $contract_object[$key[0]] = $value;
        return $contract_object;
    },$contract_objects);  
}
echo "<br><br> After Update <br> <br>";
$json_contract_objects = json_encode($contract_objects,JSON_PRETTY_PRINT);
var_dump($json_contract_objects);


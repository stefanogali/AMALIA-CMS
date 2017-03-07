<?php
session_start();
include_once('../includes/config.inc.php');
include_once('../includes/connection.php');
include_once('../includes/pages_class.php');
include("../mpdf/mpdf.php");

if(isset($_SESSION['logged_in'])){
	$subscribers = new Subscribers;
    $subscribers_fetch = $subscribers->fetch_all();

	$mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0); 
	$mpdf->setBasePath($config['app_dir']);
	//$stylesheet = file_get_contents($config['app_dir'].'/assets/style.css');
	$stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
	$mpdf->WriteHTML($stylesheet,1);

	foreach($subscribers_fetch as $subscriber){
		$return .= '<tr>
			            <td>'.$subscriber['fullName'].'</td>
			            <td>'.$subscriber['userEmail'].'</td>
			            <td>'.date('l jS \of F Y',$subscriber['subscriber_timestamp']).'</td>
			        </tr>';
	}
	$output = '<table class="table table-striped">
						    <thead>
						        <tr>
						            <th>Full name</th>
						            <th>Email</th>
						            <th>Date of subscription</th>
						        </tr>
						    </thead>
						    <tbody>
						    '. $return.'    
						    </tbody>
						</table>';
	$mpdf->WriteHTML($output);
	$mpdf->Output();
} else {
	header('Location: index.php');
}
?>
<?php 
    require_once __DIR__.'/../vendor/autoload.php'; // assumes 'vendor/' is parallel to the test folder.
    use Unudus\Validator\Validators\ValidateEmail;
    
    $arrTests = [
        [ ValidateEmail::class, "example@email.com" ],
        [ ValidateEmail::class, "" ]
    ];
    
    $strRows = '';
    foreach ( $arrTests as $arrTest )
    {
        $objTest = new $arrTest[0]( $arrTest[1] );
        $blnResult = $objTest->validate();
        
        $strRow = "
            <tr>
                <td>".$arrTest[0]::TYPE_LABEL."</td>
                <td>".htmlspecialchars( $arrTest[1], ENT_QUOTES )."</td>
                <td>".json_encode( $blnResult )."</td>
                <td>".json_encode( $objTest->getExceptions() )."</td>
            </tr>
        ";
        
        $strRows .= $strRow;
    }
    
    $strEmail = "loresum ipson son con extamery example.longerl.ength@email.com";
    
    $objTesting = new ValidateEmail( $strEmail );
    $blnEmail = $objTesting->validate();
?>
<html>
	<head>
		<title>A Simple Testing page</title>
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" /> 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous" />
		<link rel="stylesheet" href="css/testing.css" />
	</head>
	<body>
		<h1>Validation Sample Code</h1>
		<br />
		<table>
			<thead>
				<tr>
					<td>Type</td>
					<td>Test data</td>
					<td>Validates</td>
					<td>Exceptions Raised</td>
				</tr>
			</thead>
			<thead>
				<?=$strRows?>
			</thead>
		</table>
	</body>
</html>
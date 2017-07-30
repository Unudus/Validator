<?php 
    require_once __DIR__.'/../vendor/autoload.php'; // assumes 'vendor/' is parallel to the test folder.
    use Unudus\Validator\Validators\ValidateEmail;
use Unudus\Validator\Validators\ValidateStringLength;
use Unudus\Validator\Validators\ValidateURL;
use Unudus\Validator\Validators\ValidateCountryCode;
use Unudus\Validator\Validators\ValidatePasswordStrength;
    
    $arrTests = [
        [ ValidateEmail::class, "example@email.com" ],
        [ ValidateEmail::class, "exampleemail.com" ],
        [ ValidateEmail::class, "ecom" ],
        [ ValidateEmail::class, "" ],
        [ ValidateStringLength::class, "Banana", 10 ],
        [ ValidateStringLength::class, 3.5, 10 ],
        [ ValidateStringLength::class, "Banana", 5 ],
        [ ValidateStringLength::class, "Lorem", 5 ],
        [ ValidateStringLength::class, "Foo", 10, 4 ],
        [ ValidateURL::class, "http://www.google.com" ],
        [ ValidateURL::class, "www.google.com/ncr", true ],
        [ ValidateURL::class, "bing.co.uk" ],
        [ ValidateURL::class, "www.google" ],
        [ ValidateURL::class, "www.google", false ],
        [ ValidateURL::class, "lorem" ],
        [ ValidateCountryCode::class, "lorem" ],
        [ ValidateCountryCode::class, "l" ],
        [ ValidateCountryCode::class, 3 ],
        [ ValidateCountryCode::class, "GB" ],
        [ ValidatePasswordStrength::class, "lorem" ],
        [ ValidatePasswordStrength::class, "IPSOM" ],
        [ ValidatePasswordStrength::class, "Lorem" ],
        [ ValidatePasswordStrength::class, "loremIpsom" ],
        [ ValidatePasswordStrength::class, 5 ],
        [ ValidatePasswordStrength::class, "lorem56789" ],
        [ ValidatePasswordStrength::class, "loremIpsom1!" ]
    ];
    
    $strRows = '';
    foreach ( $arrTests as $arrTest )
    {
        // Note : this is a little clumsy. passing an assoc-array as the 2nd constructor parameter would clean it up, but hurt end user friendliness
        // @todo : there are many dynamic class instancing approaches, check if any convert arrays in 1..n parameters.
        
        $arrJustParms = $arrTest;
        array_shift( $arrJustParms );
        array_shift( $arrJustParms );
        if ( !isset( $arrTest[2] ) )
        {
            $objTest = new $arrTest[0]( $arrTest[1] );
        }
        else if ( !isset( $arrTest[3] ) )
        {
            $objTest = new $arrTest[0]( $arrTest[1], $arrTest[2] );
        }
        else
        {
            $objTest = new $arrTest[0]( $arrTest[1], $arrTest[2], $arrTest[3] );
        }
        $blnResult = $objTest->validate();
        
        $arrExceptions = $objTest->getExceptions();
        $strExceptions = '';
        foreach( $arrExceptions as $strException )
        {
            $strExceptions .= $strException."<br /><br />";
        }
        
        $strParams = '';
        foreach( $arrJustParms as $mxdParam )
        {
            $strParams .= json_encode( $mxdParam ).'<br /><br />';
        }
        
        $strRow = "
            <tr>
                <td>".$arrTest[0]::TYPE_LABEL."</td>
                <td>".htmlspecialchars( $arrTest[1], ENT_QUOTES )."</td>
                <td>".$strParams."</td>
                <td>".json_encode( $blnResult )."</td>
                <td>".$strExceptions."</td>
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
					<td>Extra Parameters</td>
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
# Validator
A simple data validation package

After installing package, create instances of whichever Validate* Classes you want from "Unudus\Validator\Validators". They all share "validate():bool" and "getExceptions():array" methods.

Example usage
```
use Unudus\Validator\Validators;

$objValidator = new ValidateURL( 'www.google.com', true );
if ( !$objValidator->validate() )
{
    foreach( $objValidator->getExceptions() as $strException )
    {
        // Handle as required.
    }
}.
```
For an example of executing an array of validations, see testing/index.php

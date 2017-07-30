<?php
namespace Unudus\Validator\Validators;

/**
 *
 * @author Kyle Truswell
 *        
 */
class ValidateEmail extends BaseValidate
{
    const TYPE_LABEL = "Email Validator";
    
    // Note : I've included 2 examples of meaningful exception throws, but there are many more which could be included ( local & domain checks, running checkdnsrr to check if the provided domain exists etc ).
    // because the !filter_var( $strEmail, FILTER_VALIDATE_EMAIL ) does all the main validation, omitting these just means less descriptive exceptions, and shouldn't impact the strength of the validation
    const EXCEPTION_TOO_SHORT   = "ValuepPassed too short. Email addresses need to be at least 5 characters long";
    const EXCEPTION_NO_AT       = "Value lacks a @ delimiter. The @ symbol is required between the local-part and the domain";
    const EXCEPTION_FAILS_RFC   = "Value passed did not pass the server's email standards check. See RFC 822 for rules followed";
    
    /**
     */
    public function __construct( $strEmail )
    {
        $this->mxdValue = $strEmail;
    }

    /**
     * 
     *
     *
     */
    public function validate():bool
    {
        $blnReturn = true;
        if ( !isset( $this->mxdValue ) || !is_string( $this->mxdValue ) )
        {
            $this->arrExceptions[] = static::EXCEPTION_INCORRECT_INPUT_TYPE;
            $blnReturn = false;
        }
        else
        {
            // note: strlen() does have issues with some international encodings, but shouldn't be an issue with UTF-8
            if ( strlen( $this->mxdValue ) < 5 )
            {
                $this->arrExceptions[] = static::EXCEPTION_TOO_SHORT;
                $blnReturn = false;
            }
            
            if ( stripos( $this->mxdValue, '@') === false )
            {
                $this->arrExceptions[] = static::EXCEPTION_NO_AT;
                $blnReturn = false;
            }
            
            if ( !filter_var( $this->mxdValue, FILTER_VALIDATE_EMAIL ) )
            {
                $this->arrExceptions[] = static::EXCEPTION_FAILS_RFC;
                $blnReturn = false;
            }
        }
        return $blnReturn;
    }
}
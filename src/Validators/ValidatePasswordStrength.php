<?php
namespace Unudus\Validator\Validators;

/**
 * A Validation Class for password string, specifically their strength.
 * Note : for the sake of simplicity, the class uses strlen() to gauge password atrophy,
 * but ideally it would parse out dictonary-able tokens and count those instead. 
 * E.g. "lorem" will be treated as atrophy-5, but in the face of a dictonary attack it would be realistically only 1. 
 * @author Kyle Truswell
 *        
 */
class ValidatePasswordStrength extends BaseValidate
{
    const TYPE_LABEL = "Password Strength Validator";
    
    const MIN_CHARACTER_COUNT = 8;
    
    const EXCEPTION_TOO_SHORT       = "Value wasn't long enough to be a strong password";
    const EXCEPTION_NO_CAPTIALS     = "Value lacks captialised characters.";
    const EXCEPTION_NO_LOWER_CASE   = "Value lacks lower case charatcers.";
    const EXCEPTION_NO_NUMBERS      = "Value lacks numerical characters, making it more vunerable to dictonary attacks.";
    const EXCEPTION_NO_PUNCUATION   = "Value lacks non-alpha-numeric characters, making it more vunerable to dictonary attacks. Try to include at least one of the following: ! @ # $ % ^ & * ( ) - _ = + { } ; : , < . > ";
    
    /**
     * Create a password string strength validator
     * @param $strPassword string The value, hopefully a string, to be validated as a candidate for a strong password.
     *            
     */
    public function __construct( $strPassword )
    {
        parent::__construct( $strPassword );
    }

    /**
     * Validates if the value set is a string, contains at least 1 number, 1 special character and is suffiently long.
     *  
     * @return bool Returns true if the value is a string and represents a strong password candidate, otherwise returns false.
     */
    public function validate():bool
    {
        $blnReturn = true;
        if ( !$this->isValueString() )
        {
            $this->arrExceptions[] = static::EXCEPTION_INCORRECT_INPUT_TYPE;
            $blnReturn = false;
        }
        else
        {
            // note : I could combine these regex and length checks into 1 statement, but this way I can flag exceptions for each case easily and clearly.
            if ( strlen( $this->mxdValue ) < static::MIN_CHARACTER_COUNT )
            {
                $this->arrExceptions[] = static::EXCEPTION_TOO_SHORT;
                $blnReturn = false;
            }
            
            if ( !preg_match( "#[0-9]+#", $this->mxdValue ) )
            {
                $this->arrExceptions[] = static::EXCEPTION_NO_NUMBERS;
                $blnReturn = false;
            }
            
            if ( !preg_match( "#[a-z]+#", $this->mxdValue ) )
            {
                $this->arrExceptions[] = static::EXCEPTION_NO_LOWER_CASE;
                $blnReturn = false;
            }
            
            if ( !preg_match( "#[A-Z]+#", $this->mxdValue ) )
            {
                $this->arrExceptions[] = static::EXCEPTION_NO_CAPTIALS;
                $blnReturn = false;
            }
            
            if ( !preg_match( "/[!@#$%^&*()\-_=+{};:,<.>]/", $this->mxdValue ) )
            {
                $this->arrExceptions[] = static::EXCEPTION_NO_PUNCUATION;
                $blnReturn = false;
            }
        }
        return $blnReturn;
    }
}


<?php
namespace Unudus\Validator\Validators;

/**
 * A Validation Class for strings, specifcally if their length is acceptable.
 * @author Kyle Truswell
 *        
 */
class ValidateStringLength extends BaseValidate
{
    protected $intMin;
    protected $intMax;
    
    const TYPE_LABEL = "String Length Validator";
    
    const EXCEPTION_TOO_SHORT   = "Value too short.";
    const EXCEPTION_TOO_LONG    = "Value too long.";

    /**
     * Create a string length validator
     * Note : for simplicity I'm typing and casting these lengths to int. If lengths greater than int are needed, code will need minor refactor.
     * @param $strValue string The value, hopefully a string, which you wish to bounds test
     * @param $intMax integer The largest valid length of the string
     * @param $intMin integer (optional) the smallest valid length of the string. Cannot be less than 0

     */
    public function __construct( $strValue, int $intMax, int $intMin = 0 )
    {
        $this->mxdValue = $strValue;
        // note : using (int) to make sure the parameter ends up as a usable number
        $this->intMin = max( 0, (int)$intMin );
        $this->intMax = (int)$intMax;
    }

    /**
     * Validates if the value set is a string, between the min and max values defined.
     *  
     * @return bool Returns true if the value is a string whos length is between the min and max, otherwise returns false.
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
            if ( strlen( $this->mxdValue ) < $this->intMin )
            {
                $this->arrExceptions[] = static::EXCEPTION_TOO_SHORT;
                $blnReturn = false;
            }
            
            if ( strlen( $this->mxdValue ) > $this->intMax )
            {
                $this->arrExceptions[] = static::EXCEPTION_TOO_LONG;
                $blnReturn = false;
            }
        }
        return $blnReturn;
    }
}


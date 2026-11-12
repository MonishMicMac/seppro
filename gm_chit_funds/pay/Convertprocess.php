
<?php
/********************************************************************************

   Convert Different types of string data to byte,int,float,double,byteArray

    Author : Sarika. S
    Place  : Softland India Ltd
    Date   : 29-10-2010

********************************************************************************/



/********************************************************************************/
// Function Name : bToFloat
// Parameters    : $Data - The string data to be converted from Binary String.
// Return Value  : The original value to corresponding input $Data
/********************************************************************************/

function bToFloat($Data) // 4byte
{
   $FloatValue = unpack("f",$Data);
    return $FloatValue;
}

/********************************************************************************/
// Function Name : bToByteArray
// Parameters    : $Data - The string data to be  converted from Binary String..
// Return Value  : The original value to corresponding input $Data
/********************************************************************************/

function bToByteArray($Data,$size)  // Byte Array specified by size
{
    $Format = "a".$size;
    $ByteArray = unpack($Format,$Data);
    return $ByteArray;
}


/********************************************************************************/
// Function Name : Long
// Parameters    : $Data - The string data to be  converted from Binary String.
// Return Value  : The original value to corresponding input $Data
/********************************************************************************/

function bToLong($Data)  // 4 Bytes
{
    $Long = unpack("V",$Data);
    return $Long;
}


/********************************************************************************/
// Function Name : Int
// Parameters    : $Data - The string data to be  converted from Binary String.
// Return Value  : The original value to corresponding input $Data
/********************************************************************************/

function bToInt($Data)    // 2 Bytes
{
    $Int = unpack("v",$Data);
    return $Int;
}

/********************************************************************************/
// Function Name : Byte
// Parameters    : $Data - The string data to be  converted from Binary String.
// Return Value  : The original value to corresponding input $Data
/********************************************************************************/

function bToByte($Data)    // 1 byte
{
    $Byte = unpack("C",$Data);
    return $Byte;
}

/********************************************************************************/
// Function Name : Double
// Parameters    : $Data - The string data to be  converted from Binary String.
// Return Value  : The original value to corresponding input $Data
/********************************************************************************/

function bToDouble($Data)   // 8 bytes
{
    $Double = unpack("d",$Data);
    return $Double;
}
?>


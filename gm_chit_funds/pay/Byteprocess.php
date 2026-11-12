
<?php
/********************************************************************************

   Convert Different types of string data to byte,int,float,double,byteArray

    Author : Sarika. S
    Place  : Softland India Ltd
    Date   : 29-10-2010

********************************************************************************/



/********************************************************************************/
// Function Name : Float
// Parameters    : $Data - The string data to be converted to float.
// Return Value  : The float value to corresponding input $Data
/********************************************************************************/

function Float($Data) // 4byte
{
   $FloatValue = pack("f",$Data);
    return $FloatValue;
}

/********************************************************************************/
// Function Name : ByteArray
// Parameters    : $Data - The string data to be converted to byte array.
// Return Value  : The float value to corresponding input $Data
/********************************************************************************/

function ByteArray($Data,$size)  // Byte Array specified by size
{
    $Format = "a".$size;
    $ByteArray = pack($Format,$Data);
    return $ByteArray;
}


/********************************************************************************/
// Function Name : Long
// Parameters    : $Data - The string data to be converted to long.
// Return Value  : The long value to corresponding input $Data
/********************************************************************************/

function Long($Data)  // 4 Bytes
{
    $Long = pack("V",$Data);
    return $Long;
}

/********************************************************************************/
// Function Name : Int
// Parameters    : $Data - The string data to be converted to int.
// Return Value  : The int value to corresponding input $Data
/********************************************************************************/

function Int($Data)    // 2 Bytes
{
    $Int = pack("v",$Data);
    return $Int;
}

/********************************************************************************/
// Function Name : Byte
// Parameters    : $Data - The string data to be converted to byte.
// Return Value  : The byte value to corresponding input $Data
/********************************************************************************/

function Byte($Data)    // 1 byte
{
    $Byte = pack("C",$Data);
    return $Byte;
}

/********************************************************************************/
// Function Name : Double
// Parameters    : $Data - The string data to be converted to double.
// Return Value  : The double value to corresponding input $Data
/********************************************************************************/

function Double($Data)   // 8 bytes
{
    $Double = pack("d",$Data);
    return $Double;
}


?> 


<?

    function MaskCpf($val)
    {
        return vsprintf("%s%s%s.%s%s%s.%s%s%s-%s%s", str_split($val));
    }

    function MaskPhone($val)
    {
        if(strlen($val) == 10)
        {
            return vsprintf("(%s%s) %s%s%s%s - %s%s%s%s", str_split($val));
        }
        else{
            return vsprintf("(%s%s) %s%s%s%s%s - %s%s%s%s", str_split($val));
        }
    }

?>
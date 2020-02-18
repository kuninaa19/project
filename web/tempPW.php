<?php
// 임의의 문자열 생성 ( 특수문자 포함 ) 임시비밀번호 생성기
function passwordGenerator( $length=12 ){

    $counter = ceil($length/4);
    // 0보다 작으면 안된다.
    $counter = $counter > 0 ? $counter : 1;            

    $charList = array( 
                    array("0", "1", "2", "3", "4", "5","6", "7", "8", "9", "0"),
                    array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"),
                    array("!", "@", "#", "%", "^", "&", "*") 
                );
    $password = "";
    for($i = 0; $i < $counter; $i++)
    {
        $strArr = array();
        for($j = 0; $j < count($charList); $j++)
        {
            $list = $charList[$j];

            $char = $list[array_rand($list)];
            $pattern = '/^[a-z]$/';
            // a-z 일 경우에는 새로운 문자를 하나 선택 후 배열에 넣는다.
            if( preg_match($pattern, $char) ) array_push($strArr, strtoupper($list[array_rand($list)]));
            array_push($strArr, $char);
        } 
        // 배열의 순서를 바꿔준다.
        shuffle( $strArr );

        // password에 붙인다.
        for($j = 0; $j < count($strArr); $j++) $password .= $strArr[$j];
    }
    // 길이 조정
    return substr($password, 0, $length);

}
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <table border="2px solid green">
            <?php 
                    //random table but only 1-10
                    //setting up array
                    session_start();
                    if(!isset($_SESSION['twoVar'])){
                        $_SESSION['twoVar'] = array();
                        $_SESSION['tempIndex'] = array();
                        $_SESSION['coloredIndex'] = array();
                    }
                    if(!isset($_SESSION['arrStatic'])){
                        $_SESSION['arrStatic'] = array(); 
                        $CanNotBeUsedArr = array();
                        for($i=0; $i<=100; $i++){
                            $rand = rand(1,10);
                            $freq = array_count_values($_SESSION['arrStatic']);
                            foreach($freq as $key => $count){
                                if($count == 10){
                                    array_push($CanNotBeUsedArr,$key);
                                }
                            }
                            while(in_array($rand,$CanNotBeUsedArr) && $i!=100){
                                $rand = rand(1,10);
                            }
                            array_push($_SESSION['arrStatic'],$rand);
                     
                        }
                    }
                    //setting up table
                    $id = 1;
                    for($i=0; $i<10; $i++){
                    echo "<tr>";
                        for($j=0; $j<10; $j++){
                            //recreating table with color
                            if(isset($_GET['url'])){
                                $url = $_GET['url'];
                                $arr2 = explode(',',$_GET['url']);
                                $s = $_SESSION['arrStatic'][$id];
                                $concat = $url.','.$id;
                                if(in_array($id,$arr2)){
                                    echo "<td id='$id' style='background-color: red;' '><a href='?url=$id'> $s</a></td>";
                                    if(!in_array($id,$_SESSION['tempIndex']) && count($_SESSION['tempIndex'])!= 2){
                                        array_push($_SESSION['twoVar'],$s);
                                        array_push($_SESSION['tempIndex'],$id);
                                    }
                                    if(count($_SESSION['twoVar']) == 2){
                                        if($_SESSION['twoVar'][0] == $_SESSION['twoVar'][1]){
                                            array_push($_SESSION['coloredIndex'],$_SESSION['tempIndex'][0]);
                                            array_push($_SESSION['coloredIndex'],$_SESSION['tempIndex'][1]);
                                            foreach($_SESSION['coloredIndex'] as $index){
                                                echo"
                                                <script>
                                                var myElement = document.getElementById('$index');
                                                myElement.style.backgroundColor = 'red';
                                                </script>
                                                ";
                                                $_SESSION['twoVar'] = array();
                                                $_SESSION['tempIndex'] = array();
                                            }
                                        }
                                        else{
                                            // foreach($_SESSION['tempIndex'] as $index){
                                            //     echo"
                                            //     <script>
                                            //     var myElement = document.getElementById('$index');
                                            //     myElement.style.backgroundColor = 'black';
                                            //     </script>
                                            //     ";
                                            // }
                                            echo("<script>history.replaceState({},'','4.php');</script>");
                                            $_SESSION['twoVar'] = array();
                                            $_SESSION['tempIndex'] = array();
                                        }
                                    }
                                }
                                else{
                                    echo "<td id='$id'><a href='?url=$concat'>*</a></td>";
                                }
                            }
                            //first creation of table block
                            else{
                                $s = $_SESSION['arrStatic'][$id];
                                echo "<td id='$id'><a href='?url=$id'>*</a></td>";
                            }
                            $id++;
                        }
                        echo "</tr>";
                    }
                    echo 'twoVar: '; print_r($_SESSION['twoVar']); echo '</br>';
                    echo 'tempIndex: '; print_r($_SESSION['tempIndex']); echo '</br>';
                    echo 'coloredIndex: '; print_r($_SESSION['coloredIndex']); echo '</br>';
            ?>
        </table>
        <form method="post"><button type="submit" name="clear">clear</form>
        <?php
            if(isset($_POST['clear'])){
                $_SESSION['twoVar'] = array();
                $_SESSION['tempIndex'] = array();
                $_SESSION['coloredIndex'] = array();
                echo("<script>history.replaceState({},'','4.php');</script>");
            }
        ?>
    </body>
</html>
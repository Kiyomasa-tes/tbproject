<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-01</title>
    </head>
    <body>
        <?php
        //データベースへ接続
        $dsn='データベース名';
        $user='ユーザー名';
        $password='パスワード';
        $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
        //テーブルの作成
        $sql="CREATE TABLE IF NOT EXISTS tbtest_9"
        ."("
        ."id INT AUTO_INCREMENT PRIMARY KEY,"
        ."name char(32),"
        ."comment TEXT,"
        ."date char(30),"
        ."password TEXT"
        .");";
        $stmt=$pdo->query($sql);
        if(!empty($_POST["edit"])){
            $sql='SELECT*FROM tbtest_9';
            $stmt=$pdo->query($sql);
            $result=$stmt->fetchAll();
            $edit=$_POST["edit"];
            $row=$result[$edit-1];
            $namae=$row["name"];
            $comme=$row['comment'];
        }
        ?>
        <form act="" method="post">
            <input type="text" name="password" placeholder="パスワード"><br>
            【入力フォーム】<br>
            <input type="text" name="name" placeholder="名前" value = "<?php if(!empty($_POST["edit"])) {echo $namae;} ?>"><br>
            <input type="text" name="comment" placeholder="コメント" value = "<?php if(!empty($_POST["edit"])) {echo $comme;} ?>"><br>
            <input type="hidden" name="hideedit" placeholder="編集番号" value = "<?php if(!empty($_POST["edit"])) {echo $edit;} ?>">
        【編集フォーム】<br>
            <input type="number" name="edit" placeholder="編集番号"><br>
        【削除フォーム】<br>
            <input type="number" name="delete" placeholder="削除番号"><br><br>
            <input type="submit" name="submit"><br>
        </form>
        <?php
        //編集フォーム
        if(!empty($_POST["hideedit"])&&!empty($_POST["password"])&&!empty($_POST["name"])&&!empty($_POST["comment"])){
            $sql='SELECT*FROM tbtest_9';
            $stmt=$pdo->query($sql);
            $result=$stmt->fetchAll();
            $row=$result[0];
            $password=$_POST["password"];
            if($password==$row['password']){
                $day=date("Y/m/d H:i:s");
                $date=strval($day);
                $id=$_POST["hideedit"];
                $name=$_POST["name"];
                $comment=$_POST["comment"];
                $password=$_POST["password"];
                $sql = 'UPDATE tbtest_9 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':date',$date,PDO::PARAM_STR);
                $stmt->bindParam(':password',$password,PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        //削除フォーム
        if(!empty($_POST["delete"])&&!empty($_POST["password"])){
            $password=$_POST["password"];
            $sql='SELECT*FROM tbtest_9';
            $stmt=$pdo->query($sql);
            $result=$stmt->fetchAll();
            $row=$result[0];
            if($password==$row['password']){
                $id=$_POST["delete"];
                $sql = 'delete from tbtest_9 WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        //入力フォーム
        if(!empty($_POST["password"])&&!empty($_POST["name"])&&!empty($_POST["comment"])&&empty($_POST["hideedit"])){
            $sql='SELECT*FROM tbtest_9';
            $stmt=$pdo->query($sql);
            $result=$stmt->fetchAll();
            if(!empty($result)){
                $row=$result[0];
                $password=$_POST["password"];
                if($password==$row['password']){
                    $day=date("Y/m/d H:i:s");
                    $sql=$pdo->prepare("INSERT INTO tbtest_9(name,comment,date,password)VALUES(:name,:comment,:date,:password)");
                    $sql->bindParam(':name',$name,PDO::PARAM_STR);
                    $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
                    $sql->bindParam(':date',$date,PDO::PARAM_STR);
                    $sql->bindParam(':password',$password,PDO::PARAM_STR);
                    $name=$_POST["name"];
                    $comment=$_POST["comment"];
                    $password=$_POST["password"];
                    $date=strval($day);
                    $sql->execute();
                }
            }
            else{
                $day=date("Y/m/d H:i:s");
                $sql=$pdo->prepare("INSERT INTO tbtest_9(name,comment,date,password)VALUES(:name,:comment,:date,:password)");
                $sql->bindParam(':name',$name,PDO::PARAM_STR);
                $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
                $sql->bindParam(':date',$date,PDO::PARAM_STR);
                $sql->bindParam(':password',$password,PDO::PARAM_STR);
                $name=$_POST["name"];
                $comment=$_POST["comment"];
                $password=$_POST["password"];
                $date=strval($day);
                $sql->execute();
            }
        }
        //入力したデータレコードの抽出と表示
        $sql='SELECT*FROM tbtest_9';
        $stmt=$pdo->query($sql);
        $result=$stmt->fetchAll();
        foreach($result as $row){
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].',';
            echo $row['date']."<br>";
            echo "<hr>";
        }
        ?>
    </body>
</html>
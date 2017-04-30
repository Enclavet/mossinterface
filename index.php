<html>
<head>
<title> Moss Interface </title>

<body>
<form action="handler.php" method="post" enctype="multipart/form-data">
<table>
   <tr><td>Assignment:</td><td><input name="assignment" type="text"></td></tr>
   <tr><td>Language:</td><td>
   <select name="language">
   <option value="java">Java</option>
   <option value="cc">C++</option>
   <option value="python">Python</option>
   </select>
   </td></tr>
   <tr><td>Files to Upload:</td><td><input name="upload[]" type="file" multiple="multiple" /></td></tr>
   <tr><td colspan="2"><input type="Submit" value="Submit"></td></tr>
</form>
</table>
<h3>Current Uploads</h3>
<table>
<?php
   $dirarr = scandir("./uploads/");
   foreach($dirarr as $value) {
       if($value != "." && $value != "..") {
           echo "<tr><td>".$value."</td><td><a href=\"handler.php?delete=$value\">Delete</a></td></tr>";
       }
   }
?>
</table>
</body>

</html>




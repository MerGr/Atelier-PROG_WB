<?php
$file = 'testfile.txt';
if (file_put_contents($file, "Testing file write.") !== false) {
    echo "File written successfully.";
} else {
    echo "File writing failed!";
}
?>
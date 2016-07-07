<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Input[type="file"] click test</title>
<style>
    /* ファイルは画面上に存在している必要がある。 */
    #file {
        position: absolute;
        clip: rect(0, 0, 0, 0);
    }
    #preview,
    #result {
        padding: 5px;
        border: 2px solid #000;
    }
    #preview img,
    #result img {
        width: 500px;
        max-width: 100%;
        height: auto;
    }
</style>
</head>
<body>

<h1><code>input[type="file"]</code> を JavaScript から立ち上げられるかどうかの確認</h1>

<hr>

<p>
0. <button id="reset" type="button">状態をリセットする</button>
</p>

<p>
1. <button id="button" type="button"><code>クリックしてファイル選択UIが立ち上がるかどうかを確認</code></button>
</p>

<form id="form" method="post" action="./" enctype="multipart/form-data">

<p>
2. 画像を選択する。
<input id="file" type="file" name="file"/>
</p>

<p>
3. プレビューが表示されることを確認する。
<div id="preview"></div>
</p>

<p>
4-1. <input id="submit1" type="submit" value="Submit"> 送信ボタンをクリックし POST する。
</p>

<p>
4-2. <input id="submit2" type="submit" value="Submit"> XHR2 を使って POST する。
</p>

</form>

<p>
5. 画像が送信されることを確認する。
<div id="result"><?php include('./upload.php'); ?></div>
</p>

<hr/>

<h2>調査結果</h2>

<table>
<thead>
<tr>
<th scope="col">OS</th>
<th scope="col">ブラウザ</th>
<th scope="col">結果</th>
</tr>
</thead>
<tbody>
<tr>
<td>Windows</td>
<td>Chrome</td>
<td>問題なし</td>
</tr>
<tr>
<td>Windows</td>
<td>Firefox</td>
<td>問題なし</td>
</tr>
<tr>
<td>Windows</td>
<td>IE 11</td>
<td>問題なし</td>
</tr>
<tr>
<td>Windows</td>
<td>Edge</td>
<td>問題なし</td>
</tr>
<tr>
<td>OS X</td>
<td>Safari</td>
<td>問題なし</td>
</tr>
<tr>
<td>iOS 9</td>
<td>Safari</td>
<td>問題なし</td>
</tr>
<tr>
<td>iOS 9</td>
<td>Chrome</td>
<td>問題なし</td>
</tr>
<tr>
<td>Android 4.3</td>
<td>Stock Browser</td>
<td>input が display:none ではダメ。 readAsDataURL は画像タイプが取得できない。</td>
</tr>
<tr>
<td>Android 4.4</td>
<td>Stock Browser</td>
<td>問題なし</td>
</tr>
<tr>
<td>Android 5.1</td>
<td>Stock Browser</td>
<td>問題なし</td>
</tr>
<tr>
<td>Android 5.1</td>
<td>Chrome</td>
<td>問題なし</td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
</tr>
</tbody>
</table>

<script src="https://code.jquery.com/jquery-3.0.0.min.js" integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0=" crossorigin="anonymous"></script>
<script>
    !function() {
        var $reset   = $('#reset');
        var $button  = $('#button');
        var $file    = $('#file');
        var $preview = $('#preview');
        var $submit2 = $('#submit2');
        var $result  = $('#result');
        $reset.on('click', function() {
            window.location.href = window.location.href;
        });
        $button.on('click', function() {
            $file.click();
        });
        $file.on('change', function() {
            resetFile();
            var file = $file[0].files[0];
            if (!file) {
                return;
            }
            var fileReader = new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.onloadend = function() {
                $('<img/>').attr('src', fileReader.result).appendTo($preview);
            }

        });
        $submit2.on('click', function(e) {
            e.preventDefault();
            resetFile();
            var file = $file[0].files[0];
            var formData = new FormData();
            if (file) {
                formData.append('file', file);
            }
            $.ajax('./upload.php', {
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'html'
            })
                .then(function(html) {
                    $(html).appendTo($result);
                });
        });
        function resetFile() {
            $preview.empty();
            $result.empty();
        }
    }();
</script>

</body>
</html>

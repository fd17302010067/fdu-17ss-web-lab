<html>
<head>
<title>LRC 歌词编辑器</title>
<style>
    nav ul {
        position: fixed;
        z-index: 99;
        right: 5%;
        border: 1px solid darkgray;
        border-radius: 5px;
        list-style:none;
        padding: 0;
    }

    .tab {
        padding: 1em;
        display: block;
    }

    .tab:hover {
        cursor: pointer;
        background-color: lightgray !important;
    }

    td {
        padding:0.2em;
    }

    textarea[name="edit_lyric"] {
        width: 100%;
        height: 50em;
    }

    input[type="button"] {
        width: 100%;
        height: 100%;
    }

    input[type="submit"] {
        width: 100%;
        height: 100%;
    }

    #td_submit {
        text-align: center;
    }

    select {
        display: block;
    }

    #lyric {
        width: 35%;
        height: 60%;
        border: 0;
        resize: none;
        font-size: large;
        line-height: 2em;
        text-align: center;
    }
</style>
</head>
<body>
    <nav><ul>
        <li id="d_edit" class="tab">Edit Lyric</li>
        <li id="d_show" class="tab">Show Lyric</li>
    </ul></nav>

<!--歌词编辑部分-->
<section id="s_edit" class="content">
<form id="f_upload"  action="upload_file.php" enctype="multipart/form-data">
    <p>请上传音乐文件</p>

    <!--TODO: 在这里补充 html 元素，使 file_upload 上传后若为音乐文件，则可以直接播放-->

    <input type="file" name="file_upload" accept="audio/*" onchange="upload_play(this)">
    <audio id="upload_player" autoplay="autoplay" controls="controls" style="display: none"></audio>
    <table>
        <tr><td>Title: <input type="text"></td><td>Artist: <input type="text"></td></tr>
        <tr><td colspan="2"><textarea name="edit_lyric" id="edit_lyric"></textarea></td></tr>
        <tr><td><input type="button" value="插入时间标签" onclick="insert_TimeTag()"></td><td><input type="button" value="替换时间标签"></td></tr>
        <tr><td colspan="2" id="td_submit"><input type="submit" value="Submit"></td></tr>
    </table>
</form>
</section>

<!--歌词展示部分-->
<section id="s_show" class="content">
    <select>
    <!--TODO: 在这里补充 html 元素，使点开 #d_show 之后这里实时加载服务器中已有的歌名-->
    
    </select>

    <textarea id="lyric" readonly="true">
    </textarea>
    
    <!--TODO: 在这里补充 html 元素，使选择了歌曲之后这里展示歌曲进度条，并且支持上下首切换-->
    <audio id="music_player" autoplay="autoplay"></audio>
</section>
</body>
<script>

// 界面部分
document.getElementById("d_edit").onclick = function () {click_tab("edit");};
document.getElementById("d_show").onclick = function () {click_tab("show");};

document.getElementById("d_show").click();

function click_tab(tag) {
    for (let i = 0; i < document.getElementsByClassName("tab").length; i++) document.getElementsByClassName("tab")[i].style.backgroundColor = "transparent";
    for (let i = 0; i < document.getElementsByClassName("content").length; i++) document.getElementsByClassName("content")[i].style.display = "none";

    document.getElementById("s_" + tag).style.display = "block";
    document.getElementById("d_" + tag).style.backgroundColor = "darkgray";
} 

// Edit 部分
var edit_lyric_pos = 0;
document.getElementById("edit_lyric").onmouseleave = function () {
    edit_lyric_pos = document.getElementById("edit_lyric").selectionStart;
};

// 获取所在行的初始位置。
function get_target_pos(n_pos) {
    if (n_pos === undefined) n_pos = edit_lyric_pos;
    let value = document.getElementById("edit_lyric").value; 
    let pos = 0;
    for (let i = n_pos; i >= 0; i--) {
        if (value.charAt(i) === '\n') {
            pos = i + 1;
            break;
        }
    }
    return pos;
}

// 选中所在行。
function get_target_line(n_pos) {
    let value = document.getElementById("edit_lyric").value; 
    let f_pos = get_target_pos(n_pos);
    let l_pos = 0;

    for (let i = f_pos;; i++) {
        if (value.charAt(i) === '\n') {
            l_pos = i + 1;
            break;
        }
    }
    return [f_pos, l_pos];
}

/* HINT: 
 * 已经帮你写好了寻找每行开头的位置，可以使用 get_target_pos()
 * 来获取第一个位置，从而插入相应的歌词时间。
 * 在 textarea 中，可以通过这个 DOM 节点的 selectionStart 和
 * selectionEnd 获取相对应的位置。
 *
 * TODO: 请实现你的歌词时间标签插入效果。
 */

function upload_play(source){
    let file = source.files[0];
    if (window.FileReader){
        let fr = new FileReader();
        fr.onloadend = function (e) {
            let player = document.getElementById("upload_player");
            player.src = e.target.result;
            player.style.display = "block";
        };
        fr.readAsDataURL(file);
    }
}
function insert_TimeTag(){
    let pos = get_target_pos();
    let player = document.getElementById("upload_player");
    let time = player.currentTime;
    let timeValue = "[";
    let hour = parseInt(time / 60 / 60);
    if (hour < 10)
        timeValue += "0"+hour;
    else
        timeValue += hour;
    timeValue += ":";
    time -= hour * 60 * 60;
    let minute = parseInt(time / 60);
    if (minute < 10)
        timeValue += "0"+minute;
    else
        timeValue += minute;
    timeValue += ":";
    time -= minute * 60;
    if (time < 10)
        timeValue += "0"+ time.toFixed(2);
    else
        timeValue += time.toFixed(2);
    timeValue += "]";

    let origin = document.getElementById("edit_lyric").value;
    document.getElementById("edit_lyric").value = origin.substr(0,pos) + timeValue + origin.substr(pos);
}

/* TODO: 请实现你的上传功能，需包含一个音乐文件和你写好的歌词文本。
 */

/* HINT: 
 * 实现歌词和时间的匹配的时候推荐使用 Map class，ES6 自带。
 * 在 Map 中，key 的值必须是字符串，但是可以通过字符串直接比较。
 * 每一行行高可粗略估计为 40，根据电脑差异或许会有不同。
 * 当前歌词请以粗体显示。
 * 从第八行开始，当歌曲转至下一行的时候，需要调整滚动条，使得当前歌
 * 词保持在正中。
 *
 * TODO: 请实现你的歌词滚动效果。
 */

</script>



</html>

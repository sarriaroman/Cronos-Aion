<?php

function loadTags() {
    $tags = Languages::getTags();

    $v = tue;

    while ($tag = mysql_fetch_object($tags)) {
        echo ( $v ) ? '<tr class="odd">' : '<tr>';

        echo '<td><span style="color:red;"><strong>' . $tag->tag . ' (' . $tag->lang . ')</strong></span>';
        //echo        '<ul id="info_'. $tag->id.'" style="background-color: #F6F6; width: 400px;"><pre style="width: 400px;">'. $tag->value .'</pre></ul>';
        echo '<ul id="text_' . $tag->id . '" style="display: ;"><textarea id="' . $tag->id . '" style="height: 200px; width: 100%;">' . $tag->value . '</textarea></ul>';
        echo '</td>';
        echo '<td class="action">';
        //echo        "<span class='view' id='edi_". $tag->id."' onclick='edit(".$tag->id.");' style='cursor: pointer; '>Editar</span>";
        echo "<span class='view' id='sav_" . $tag->id . "' onclick='save(" . $tag->id . ");' style='cursor: pointer; display: ;'>Guardar</span>";
        echo '</td>';
        echo "</tr>";
        $v = !$v;
    }
}

function editTag() {
    if (isset($_REQUEST['tag'])) {
        $tags = Languages::getSingleTag($_REQUEST['tag']);
    } else
        return false;

    $tag = mysql_fetch_object($tags);
    $pos_points = (strpos($tag->tag, ':') + 1);
    echo '<td><span style="color:red;"><strong>' . substr($tag->tag, $pos_points, strlen($tag->tag)) . ' (' . $tag->lang . ')</strong></span>';
    echo '<ul id="text_' . $tag->id . '" style="display: ;">            
            <textarea id="' . $tag->id . '" style="height: 200px; width: 100%;">' . $tag->value . '</textarea>';
    echo '<script type="text/javascript">
                CKEDITOR.config.resize_maxWidth=\'300\';
                CKEDITOR.config.resize_minWidth=\'300\';
                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                CKEDITOR.replace(\'' . $tag->id . '\');
            </script>';
    echo '</ul>';
    echo '</td>';
    echo '<td class="action">';
    //echo        "<span class='view' id='edi_". $tag->id."' onclick='edit(".$tag->id.");' style='cursor: pointer; '>Editar</span>";
    echo "<span class='view' id='sav_" . $tag->id . "' onclick='save(" . $tag->id . ");' style='cursor: pointer; display: ;'>Guardar</span>";
    echo '</td>';
    echo "</tr>";
}

function loadSideSections() {
    $sections = Sections::loadSections('es');
    if (isset($_REQUEST['tag'])) {
        $tags_selected = Languages::getSingleTag($_REQUEST['tag']);
        $tag_selected = mysql_fetch_object($tags_selected);
    }

    while ($sect = mysql_fetch_object($sections)) {
        echo '<li class="section"><a href="javascript:;" onclick="$(\'.sub_list_' . $sect->id . '\').slideToggle();">' . $sect->name . '</a>';
        if (!isset($tag_selected)) {
            echo '<ul class="sub_list sub_list_' . $sect->id . '">';
            $tags = Languages::getSectionsTags($sect->id);

            while ($tag = mysql_fetch_object($tags)) {
                $pos_points = (strpos($tag->tag, ':') + 1);
                echo '<li><a href="' . base_url . 'admin.php?section=translate&tag=' . $tag->id . '">' . substr($tag->tag, $pos_points, strlen($tag->tag)) . '</li>';
            }
        } else {
            echo '<ul class="sub_list sub_list_' . $sect->id . '" ' . ($tag_selected->section == $sect->id ? 'style="display:block;"' : '') . '>';
            $tags = Languages::getSectionsTags($sect->id);

            while ($tag = mysql_fetch_object($tags)) {
                $pos_points = (strpos($tag->tag, ':') + 1);
                echo '<li ' . ($tag_selected->id == $tag->id ? 'style="font-weight:bold;"' : '') . '><a href="' . base_url . 'admin.php?section=translate&tag=' . $tag->id . '">' . substr($tag->tag, $pos_points, strlen($tag->tag)) . '</li>';
            }
        }

        echo '</ul></li>';
    }
}

function printTagHeader() {
    if (isset($_REQUEST['tag'])) {
        $tags = Languages::getSingleTag($_REQUEST['tag']);
        $tag = mysql_fetch_object($tags);
        $pos_points = (strpos($tag->tag, ':') + 1);

        $other_tags = Languages::getOtherLanguage($tag->tag, $tag->id);
        $other_tag = mysql_fetch_object($other_tags);
        echo '<h2>
            <a href="#">Translate</a> &raquo;
            <a href="#" class="active">' . substr($tag->tag, $pos_points, strlen($tag->tag)) . ' (' . $tag->lang . ')</a>

         </h2>
         <p class="other_lang"><a href="' . base_url . 'admin.php?section=translate&tag=' . $other_tag->id . '">Edit ' . ($tag->lang == 'es' ? 'english' : 'spanish') . '</a></p>';
    } else
        echo '<p>Select tag to edit on sidebar</p>';
}

?>
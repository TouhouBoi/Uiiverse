<?php
require_once('lib/htm.php');
require_once('lib/htmUsers.php');

function hexToHsl($color, $returnAsArray=false){$color=str_replace('#', '', $color);$R=hexdec($color[0].$color[1]);$G=hexdec($color[2].$color[3]);$B=hexdec($color[4].$color[5]);$HSL=array();$var_R=($R/255);$var_G=($G/255);$var_B=($B/255);$var_Min=min($var_R, $var_G, $var_B);$var_Max=max($var_R, $var_G, $var_B);$del_Max=$var_Max-$var_Min;$L=($var_Max+$var_Min)/2;if($del_Max==0){$H=0;$S=0;}else{if($L<0.5)$S=$del_Max/($var_Max+$var_Min);else$S=$del_Max/(2-$var_Max-$var_Min);$del_R=((($var_Max-$var_R)/6)+($del_Max/2))/$del_Max;$del_G=((($var_Max-$var_G)/6)+($del_Max/2))/$del_Max;$del_B=((($var_Max-$var_B)/6)+($del_Max/2))/$del_Max;$H=0.5;if($var_R==$var_Max)$H=$del_B-$del_G;elseif($var_G==$var_Max)$H=(1/3)+$del_R-$del_B;elseif($var_B==$var_Max)$H=(2/3)+$del_G-$del_R;if($H<0)$H++;if($H>1)$H--;}$HSL['H']=round(($H*360));$HSL['S']=round(($S*100));$HSL['L']=round(($L*100));return$returnAsArray?$HSL:implode(",", $HSL);}

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	$tabTitle = 'Uiiverse - Ajustes de Uiiverse';
	printHeader('');

	$get_user = $dbc->prepare('SELECT * FROM users INNER JOIN profiles ON profiles.user_id = users.user_id WHERE users.user_id = ? LIMIT 1');
	$get_user->bind_param('i', $_SESSION['user_id']);
	$get_user->execute();
	$user_result = $get_user->get_result();
	$user = $user_result->fetch_assoc();
    $get_prof = $dbc->prepare('SELECT * FROM profiles INNER JOIN posts ON id = fav_post AND deleted = 0 WHERE user_id = ?');
		$get_prof->bind_param('i', $user['user_id']);
		$get_prof->execute();
		$prof_result = $get_prof->get_result();
		$profile = $prof_result->fetch_assoc();
	echo '<div id="sidebar" class="general-sidebar">';
	userContent($user, "");
	sidebarSetting();
	echo '</div>
	<div class="main-column">
	  <div class="post-list-outline">
	    <h2 class="label">Ajustes de Uiiverse</h2>
	    <form id="account-settings-form" class="setting-form" method="post" action="/settings/account">
	      <ul class="settings-list">
          <li>
                  <p class="settings-label"><label for="user_relationship_visibility">¿Quien puede comentar en tus publicaciones?</label></p>
	          <div class="select-content">
	            <div class="select-button">
	              <select name="user_relationship_visibility">
	                <option value="1"'. ($profile['user_relationship_visibility'] == 1 ? ' selected' : '') .'>Todos</option>
	                <option value="2"'. ($profile['user_relationship_visibility'] == 2 ? ' selected' : '') .'>Nadie</option>
	              </select>
	            </div>
	          </div>
	        </li>
                  <li>
                  <p class="settings-label"><label for="locale.lang">¿En qué idioma de otros usuarios quieres ver las publicaciones en comunidades?</label></p>
	          <div class="select-content">
	            <div class="select-button">
	              <select name="locale.lang">
	                <option value="1">English (US)</option>
	                <option value="2">Español (Latinoamérica)</option>
                    <option value="3">Français (France)</option>
                    <option value="4">Português (Brasil)</option>
                    <option value="5">Deustch</option>
                    <option value="6">Italiano</option>
                    <option value="7">Nederlands</option>
                    <option value="8">Русский</option>
                    <option value="9">Українська</option>
                    <option value="10">عربى</option>
                    <option value="11">हिंदी</option>
                    <option value="12">繁體中文</option>
                    <option value="13">简体中文</option>
                    <option value="14">한국어</option>
                    <option value="15">日本語</option>
	              </select>
	            </div>
	          </div>
	        </li>
            <li>
                  <p class="settings-label"><label for="locale.lang">¿Quieres que las publicaciones creadas automaticamente por juegos aparezcan en Actividad?</label></p>
	          <div class="select-content">
	            <div class="select-button">
	              <select name="locale.lang">
	                <option value="1">Si</option>
	                <option value="2">No</option>
	              </select>
	            </div>
	          </div>
	        </li>
            <li>
	          <p class="settings-label"><label for="select_notify.empathy_notice_opt_out">¿Quieres recibir notificaciónes de Molas?</label></p>
	          <div class="select-content">
	            <div class="select-button">
	              <select name="yeah_notifs" id="yeah_notifs">
	                <option value="1"'. ($user['yeah_notifs'] == 1 ? ' selected' : '') .'>Recibir</option>
	                <option value="0"'. ($user['yeah_notifs'] == 0 ? ' selected' : '') .'>NoRecibir</option>
	              </select>
                  </div>
                  </div>
                  </li>
	      </ul>
	      <div class="form-buttons"><input type="submit" class="black-button apply-button" value="Guardar Ajustes" data-community-id="" data-url-id="" data-track-label="user" data-title-id="" data-track-action="changeSetting" data-track-category="setting"></div>
	    </form>
	  </div>
	</div>
  </div>
</div>
<div class="dialog active-dialog modal-window-open mask none">
  <div class="dialog-inner">
    <div class="window">
      <h1 class="window-title"></h1>
      <div class="window-body">
        <p class="window-body-content">Cambios guardados.</p>
        <div class="form-buttons">
          <button class="ok-button black-button" type="button" data-event-type="ok">OK</button>
        </div>
      </div>
    </div>
  </div>
</div>';
} else {
	if(!($_POST['yeah_notifs'] == 0 || $_POST['yeah_notifs'] == 1)){$errors[]='stop';}
    if(!($_POST['user_relationship_visibility'] == 1 || $_POST['user_relationship_visibility'] == 2)){$errors[]='stop';}
	if(empty($errors)){
		$user_change = $dbc->prepare('UPDATE profiles SET yeah_notifs = ? WHERE user_id = ?');
		$user_change->bind_param('ii', $_POST['yeah_notifs'], $_SESSION['user_id']);
		$user_change->execute();
        $user_change = $dbc->prepare('UPDATE profiles SET user_relationship_visibility = ? WHERE user_id = ?');
		$user_change->bind_param('ii', $_POST['user_relationship_visibility'], $_SESSION['user_id']);
		$user_change->execute();
		if (isset($_POST['theme-color']) && $_POST['theme-color'] != '#000000'){
			setcookie('cedar_color_theme', hexToHsl($_POST['theme-color']), strtotime('+10 days'), '/');
			setcookie('hex_color_theme', $_POST['theme-color'], strtotime('+10 days'));
		} else {
			setcookie('cedar_color_theme', 'NULL', strtotime('-20 days'), '/');
			setcookie('hex_color_theme', 'NULL', strtotime('-20 days'));
		}
		echo 'Cambios guardados.';
	}
}

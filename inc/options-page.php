<?php
/**
 * Page admin for "Background Music Options" page.
 *
 * @package wp-background-music
 */

//save POST to options
if(isset($_POST['data'])){
    update_option('wpbgn_music_options', $_POST['data']);
}

$dataoption = get_option('wpbgn_music_options',[]);
$urlaudio   = isset($dataoption['urlaudio']) ? $dataoption['urlaudio'] : '';
$message    = isset($dataoption['message']) ? $dataoption['message'] : 'This website has a song in the background. Do you allow it ?';
$showbubble = isset($dataoption['showbubble']) ? $dataoption['showbubble'] : '0';
//print_r($dataoption);
?>
<div class="wrap">
    <h2>Background Music Options</h2>

    <form action="" method="post">
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">URL Audio</th>
                    <td>
                        <input name="data[urlaudio]" id="urlaudio" type="text" value="<?php echo $urlaudio;?>" class="widefat code">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Bubble Message</th>
                    <td>
                        <label for="show_bubble">
                            <input type="checkbox" id="show_bubble" name="data[showbubble]" value="1" <?php echo $showbubble==1?'checked':'';?>>
                            Show Bubble	
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Message for Allow</th>
                    <td>
                        <textarea name="data[message]" rows="10" cols="50" id="message" class="large-text"><?php echo $message;?></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>
    </form>

</div>
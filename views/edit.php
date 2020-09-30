<div style="padding: 30px; font-size: 16px;">
    <h1 style="padding-bottom: 10px;">Edit facebook page showcase</h1>
    <form action="" method="post">
        <?php
        global $wpdb;
        $showcase = $wpdb->get_row('SELECT * FROM brian_facebook_pages WHERE id=' . $_GET['id'], 'ARRAY_A');
        ?>
        <table>
            <tr>
                <td>Name: </td>
                <td> <input type="text" name="name" value="<?= $showcase['name']; ?>" class="regular-text"> </td>
            </tr>
            <tr>
                <td>Phone: </td>
                <td> <input type="text" name="phone" value="<?= $showcase['phone']; ?>" class="regular-text"> </td>
            </tr>
            <tr>
                <td>Email: </td>
                <td> <input type="text" name="email" value="<?= $showcase['email']; ?>" class="regular-text"> </td>
            </tr>
            <tr>
                <td>Page Link: </td>
                <td>
                    <input type="text" name="page_link" value="<?= $showcase['page_link']; ?>" class="regular-text">
                    <input type="hidden" name="id" value="<?= $showcase['id']; ?>">
                </td>
            </tr>
            <tr>
                <td>Status: </td>
                <td>
                    <select name="is_approved">
                        <option <?= ($showcase['is_approved'] == 0) ? 'selected' : ''; ?> selected value="0">Pending</option>
                        <option <?= ($showcase['is_approved'] == 1) ? 'selected' : ''; ?> value="1">Approved</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" style="cursor: pointer; background: #3fae27;margin-top: 20px;padding: 10px 30px;color: #fff;border: none;">SUBMIT</button>
                </td>
                <td></td>
            </tr>
        </table>

    </form>
</div>
<div class="wrap">

    <div class="edit-form-section">
        <h1>CMS Locking</h1>
    </div>

    <?php // Success messages for locking CMS ?>
    <?php if (isset($_GET['locked'])) : ?>
        <div id="message" class="updated notice notice-success is-dismissible">
            <p>The CMS has been <?= $_GET['locked'] ? 'locked' : 'unlocked' ?>.</p>
            <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>
    <?php endif ?>

    <?php // Success messages for updating users to lock ?>
    <?php if (isset($_GET['success'])) : ?>
        <div id="message" class="updated notice notice-success is-dismissible">
            <p>The users to lock out of the CMS (when locked) have been updated.</p>
            <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>
    <?php endif ?>

    <?php // Global CMS locking switch ?>
    <div class="edit-term-notes">
        <?php if (!empty($isLocked)) : ?>
            <p>This CMS is currently locked. Would you like to unlock it so that all users can log in?</p>
            <a href="<?php menu_page_url($_GET['page']) ?>&lock=0" class="button button-primary">Unlock CMS</a>
        <?php else : ?>
            <p>This CMS is not currently locked, so all users can log in. Would you like to lock it?</p>
            <a href="<?php menu_page_url($_GET['page']) ?>&lock=1" class="button button-primary">Lock CMS</a>
        <?php endif ?>
    </div>

    <?php // Customiser for who gets locked out ?>
    <?php if (!empty($allUsers)) : ?>
        <form method="POST" class="edit-term-notes">
            <fieldset>
                <legend>Which users would you like to <strong>prevent</strong> from logging in when the CMS is locked?</legend>


                <?php foreach ($allUsers as $user) : ?>
                    <p>
                        <label>
                            <input type="checkbox"
                                name="locked_users[]"
                                value="<?= $user->ID ?>"
                                <?= in_array($user->ID, $lockedUsers ?? []) ? 'checked' : '' ?>
                            />

                            <?= ucwords($user->data->display_name) ?>
                        </label>
                    </p>
                <?php endforeach ?>

            </fieldset>
            <button class="button button-primary" type="submit">Update</button>
        </form>
    <?php endif ?>
</div>

<div class="wpl-settings wrap">

    <div class="wpl-settings__col--left">
        <h1 class="wpl-settings__heading">CMS Locking</h1>

        <?php // Success messages for locking CMS ?>
        <?php if (isset($_GET['locked'])) : ?>
            <div class="wpl-settings__block">
                <div id="message" class="updated notice notice-success is-dismissible">
                    <p>The CMS has been <?= $_GET['locked'] ? 'locked' : 'unlocked' ?>.</p>
                </div>
            </div>
        <?php endif ?>

        <?php // Success messages for updating users to lock ?>
        <?php if (isset($_GET['success'])) : ?>
            <div class="wpl-settings__block">
                <div id="message" class="updated notice notice-success is-dismissible">
                    <p>The users to lock out of the CMS (when locked) have been updated.</p>
                </div>
            </div>
        <?php endif ?>

        <?php // Global CMS locking switch ?>
        <div class="wpl-settings__block">
            <h2>Status: <?= $isLocked ? 'Locked' : 'Unlocked' ?></h2>
            <?php if (!empty($isLocked)) : ?>
                <p>This CMS is currently locked. Would you like to unlock it so that all users can log in?</p>
                <a href="<?php menu_page_url($_GET['page']) ?>&lock=0" class="button button-primary">Unlock CMS</a>
            <?php else : ?>
                <p>This CMS is not currently locked, so all users can log in. Would you like to lock it?</p>
                <a href="<?php menu_page_url($_GET['page']) ?>&lock=1" class="button button-primary">Lock CMS</a>
            <?php endif ?>
        </div>

        <div class="wpl-settings__block">
            <h2>Users to lock out</h2>

            <?php // Customiser for who gets locked out ?>
            <?php if (empty($allUsers)) : ?>
                <p>You're the only user in the CMS< and you can't lock yourself out.</p>
            <?php else : ?>
                <form method="POST">
                    <input type="hidden" name="lock_selected_users" value="1" />

                    <fieldset>
                        <legend>Which users would you like to <strong>prevent</strong> from logging in when the CMS is locked?</legend>


                        <?php foreach ($allUsers as $user) : ?>
                            <p>
                                <label class="wpl-settings__label">
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
                    <a class="wpl-settings__button-link" href="<?php menu_page_url($_GET['page']) ?>&lock_all_users=1">
                        <button class="button" type="button">Lock out all</button>
                    </a>
                    <button class="button button-primary" type="submit">Lock out selected</button>

                </form>
            <?php endif ?>
        </div>

        <div class="wpl-settings__block">
            <h2>Lockout message</h2>

            <form method="POST">
                <input type="hidden" name="update_lockout_message" value="1" />

                <label>What message do you want to show to locked out users?</label>
                <input class="wpl-settings__input" type="text" name="lockout_message" value="<?= $lockoutMessage ?? '' ?>" />

                <button class="button button-primary" type="submit">Update message</button>
            </form>
        </div>
    </div>

    <div class="wpl-settings__col--right">
        <section class="wpl-settings__block wpl-settings__block--white ">
            <h2>Who can log in right now?</h2>

            <ul>
                <li>You</li>
                <?php if (!empty($allUsers)) : ?>
                    <?php foreach ($allUsers as $user) : ?>
                        <?php if (!$isLocked || !in_array($user->ID, $lockedUsers ?? [])) : ?>
                            <li><?= $user->data->display_name ?></li>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
            </ul>
        </section>
    </div>
</div>

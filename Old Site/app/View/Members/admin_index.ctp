<div class="reportlistblock" id="Registered_Members">
    <h2>Registered Members</h2>
    <div class="report-tbl-row-header">
        <div class="child table-header report-tbl-item-member">Member</div>
        <div class="child table-header report-tbl-item-header">DOB</div>
        <div class="child table-header report-tbl-item-header">Gender</div>
        <div class="child table-header report-tbl-item-header">Skill Level</div>
        <div class="child table-header report-tbl-item-header">Subsciption</div>
        <div class="child table-header report-tbl-item-header">Account Expires</div>
        <div class="child table-header report-tbl-item-header item-link">&nbsp;</div>
    </div>
    <div class="clear"></div>

    <?php
        foreach($members as $member)
        {
            if(isset($member['MemberSubscription'][0]['subscription_expires']))
                $expire = date('F d, Y', strtotime($member['MemberSubscription'][0]['subscription_expires']));
            else
                $expire = 'N/A';

            if(isset($member['MemberSubscription']['active']) && $member['MemberSubscription']['active'] == 1)
                $active = 'Yes';
            else
                $active = 'No';

            if(isset($member['Member']['dob']))
                $dob = $member['Member']['dob'];
            else
                $dob = 'Pending';

            ?>
                <a href="/admin/members/view/<?php echo $member['Member']['id']; ?>">
                    <div class="parentz">
                        <div class="child report-tbl-item-member"><?php echo $member['Member']['name']." ".$member['Member']['surname']; ?></div>
                        <div class="child report-tbl-item item-center"><?php echo $dob; ?></div>
                        <div class="child report-tbl-item item-center"><?php echo $member['Member']['gender']; ?></div>
                        <div class="child report-tbl-item item-center"><?php echo $member['MemberDetail'][0]['skill_level']; ?></div>
                        <div class="child report-tbl-item item-center"><?php echo $active; ?></div>
                        <div class="child report-tbl-item item-center"><?php echo $expire ?></div>
                        <div class="child report-tbl-item item-center item-link">
                            <div align="center" class="report-expand report-expand2"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </a>
                <div class="clear"></div>
            <?php
        }
    ?>

    <div id="pagelinks">
        <?php
            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
    <div class="clear"></div>

</div>


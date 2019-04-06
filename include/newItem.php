<form action="addItem.php" method="post" id="add-item-window" class="add-window">
    <div class="add-window-header event-bg-color">
        <div class="add-window-header-icon event-icon"></div>
        <div class="add-window-header-title">Create new item</div>
        <button type="button" class="add-window-close window-close"></button>
    </div>
    <div id="itemMainInfo" class="add-window-form">
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Eduscape SKU</label>
                <input type="text" name="eduscapeSKU" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Workshop Group</label>
                <input type="text" name="workshopGroup" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-3">
                <label>Track</label>
                <input type="text" name="track" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-3">
                <label>Format</label>
                <input type="text" name="format" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Time (hours)</label>
                <input type="number" name="timeH" placeholder="">
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-16">
                <label>Title of Offering</label>
                <input type="text" name="titleOfOffering" placeholder="">
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-y-10  form-x-8">
                <label>Description</label>
                <textarea name="description"></textarea>
            </div>
            <div class="add-window-form-section-cell  form-y-10 form-x-8">
                <label>Learner Outcomes</label>
                <textarea name="learnerOutcomes"></textarea>
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell  form-y-10 form-x-8">
                <label>Prerequisites</label>
                <textarea name="prerequisites"></textarea>
            </div>
            <div class="add-window-form-section-cell form-y-10 form-x-8">
                <label>Toolbox</label>
                <textarea name="toolbox"></textarea>
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell  form-y-10 form-x-8">
                <label>Notes</label>
                <textarea name="notes"></textarea>
            </div>
            <div class="add-window-form-section-cell  form-y-10 form-x-8">
                <label>Audience</label>
                <textarea name="audience"></textarea>
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Status</label>
                <input type="text" name="status" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Last Update</label>
                <input type="text" name="lastUpdate" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>MSRP</label>
                <input type="text" name="MSRP" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>MAP</label>
                <input type="text" name="MAP" placeholder="">
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>CLIENT COST</label>
                <input type="text" name="clientCost" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Author</label>
                <input type="text" name="author" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Materials</label>
                <input type="text" name="materials" placeholder="">
            </div>
        </div>



    </div>
    <div class="add-window-footer">
        <div class="add-window-footer">
            <button id="itemDefaultOpen" onclick="openWindowTab(event, 'itemMainInfo')" type="button" class="add-window-tab defaultOpen">Main Fields</button>
            <div></div>
            <div></div>
            <button type="reset" class="add-window-button-cancel window-close">Cancel</button>
            <button type="submit" class="add-window-button-save">Save</button>
        </div>
    </div>
</form>
import { expect, test } from "@playwright/test";
import { HOST, GLOBAL_TIMEOUT, CmfiveHelper } from "@utils/cmfive";
import { ParkmanagerHelper } from "@utils/parkmanager";

test.describe.configure({mode: 'parallel'});

test("Test that you can add a site", async ({ page, isMobile }) => {
    
    test.setTimeout(30000);
    CmfiveHelper.acceptDialog(page);

    await CmfiveHelper.login(page, "admin", "admin");

    
    for (var i = 0; i < 1; i++){
        const siteName = CmfiveHelper.randomID("SiteName_" + i + "_");

        const isElectric = Math.random() < 0.5 ? true : false;
        const isMaintenance = Math.random() < 0.5 ? true : false;

        await ParkmanagerHelper.addNewSite(page, isMobile, siteName, isElectric, isMaintenance);
    }

});
test("Test that you can add a Booking", async ({ page, isMobile }) => {
    
    test.setTimeout(30000);
    CmfiveHelper.acceptDialog(page);

    await CmfiveHelper.login(page, "admin", "admin");

    
    for (var i = 0; i < 10; i++){
        const Contact = CmfiveHelper.randomID("Contact_" + i + "_");

        await ParkmanagerHelper.addNewBooking(page, isMobile, Contact);
    }

});
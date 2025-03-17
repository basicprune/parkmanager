import { HOST, CmfiveHelper } from "@utils/cmfive";
import { expect, Page } from "@playwright/test";
import { DateTime } from "luxon";

export class ParkmanagerHelper  {


    static async addNewSite(page: Page, isMobile: boolean, siteName: string, isElectric: boolean, isMaintenance: boolean){

        
        
        // await expect(page.getByText("Add Widget")).toBeVisible();

        if(page.url() != HOST + "/parkmanager")
            await page.getByText("Parkmanager", {exact: true}).click(); 
            //await CmfiveHelper.clickCmfiveNavbar(Page, isMobile, "Parkmanager");
        await page.waitForURL(HOST + "/parkmanager");
        

        await page.getByText("Add New Site", {exact: true}).click();

        await page.locator("#sitename").fill(siteName);

        // const maintenanceCheckBox = await page.getByRole("checkbox", {name: "is_closed"});
        // await page.waitForTimeout(100);
        // if (isMaintenance) {
        //     await maintenanceCheckBox.check();
        // }

        const electricCheckBox = await page.getByRole("checkbox", {name: "electricity"});
        if (isElectric) {
            await electricCheckBox.check();
        }
       

        // const otherCheckBox = await page.getByRole("checkbox", {name: "is_closed"});
        const otherCheckBox = await page.getByLabel("Site Is Under Maintenence (Check the box if the site is)");
        if (isMaintenance) {
            await otherCheckBox.check();
        }

        await page.getByRole("button", {name: "Save"}).click();

    }
    
    static async addNewBooking(page : Page, isMobile: boolean, contact: string){

        if(page.url() != HOST + "/parkmanager" )
            await page.getByText("Parkmanager", {exact: true}).click(); 
        //     //await CmfiveHelper.clickCmfiveNavbar(Page, isMobile, "Parkmanager");
        await page.waitForURL(HOST + "/parkmanager");
        

        await page.getByText("Add New Booking", {exact: true}).click();

        // await page.locator("#firstname0").fill("fn_" + contact);
        await page.locator("#lastname0").fill("ln_" + contact);
        await page.locator("#mobile0").fill("mobile_" + contact);
        await page.locator("#email0").fill("email_" + contact);
        
        const randomYear = Math.random() * (2030 - 2025) + 2025;
        const randomMonth = Math.random() * (12 - 1) + 1;
        const randomday = Math.random() * (28 - 1) + 1;

        const BookingStartDate = new DateTime("utc");
        BookingStartDate.set({ year:  randomYear, month: randomMonth, day: randomday});
        
        // const dateString = randomday + randomMonth + randomYear; 01022025
        // const BookingStartDate = DateTime.fromFormat(dateString, 'ddLLyyyy');
        

        const BookingEndDate = BookingStartDate.plus({ days: Math.random() * (10 - 1) + 1 });
        
        await page.locator("#firstname0").fill("fn_" + contact + BookingStartDate.toFormat("ddLLyyyy"));

        await CmfiveHelper.fillDatePicker(page, "Start Of Stay", "dt_startofstaydate", BookingStartDate);
        await CmfiveHelper.fillDatePicker(page, "End Of Stay", "dt_endofstaydate", BookingEndDate);
        
        
    
        await page.locator("#rate").fill("500");

        await page.getByRole("combobox", {name: "Site"}).selectOption(new RegExp("/[^ ]* \(Is Available\) \([^)]*\)/gm"));

        await page.getByRole("button", {name: "Save"}).click();
    }

}
function get() {
    let xhttp = new XMLHttpRequest()
    xhttp.open("POST", "/as-projekt/highscores.php", true)
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let captchaDisp = document.getElementById("captcha-cont")
            captchaDisp.innerHTML = "CAPTCHA<br>"
            let captchaImg = new Image()
            captchaImg.src = "/akm-coins/captcha.php?" + Date.now()
            captchaImg.style.width = "80px"
            captchaImg.style.height = "40px"
            captchaDisp.append(captchaImg)
            captchaImg.addEventListener('load', getCaptcha)

            var alloyTable = ["aluminum", "aluminum-bronze", "copper plated zinc", "copper-nickel", "gold", "nickel bonded steel", "silver", "stainless steel", "zinc"]
            var countryTable = ["POLSKA", "ROSJA", "TUNEZJA", "CHINY", "ALBANIA", "ALGIERIA", "VIETNAM"]

            let ob = JSON.parse(this.responseText)

            let cont = document.getElementById("cont")
            let table = document.createElement("table")


            let tr = document.createElement("tr")
            table.append(tr)

            let th_country = document.createElement("th")
            tr.append(th_country)

            let th_denom = document.createElement("th")
            th_denom.innerHTML = "Denom."
            tr.append(th_denom)

            let th_cat_number = document.createElement("th")
            th_cat_number.innerHTML = "Cat. Number"
            tr.append(th_cat_number)

            let th_alloy = document.createElement("th")
            th_alloy.innerHTML = "Alloy"
            tr.append(th_alloy)

            let th_date = document.createElement("th")
            th_date.innerHTML = "Date"
            tr.append(th_date)

            let th_captchaCont = document.createElement("th")
            th_captchaCont.innerHTML = "Captcha"
            tr.append(th_captchaCont)

            let th_delCont = document.createElement("th")
            tr.append(th_delCont)


            cont.innerHTML = ""
            cont.append(table)

            ob.forEach(function (k, v) {
                let tr = document.createElement("tr")
                tr.id = "tr" + v
                table.append(tr)

                let id = document.createElement("input")
                id.id = "id" + v
                id.type = "hidden"
                id.value = k.id
                tr.append(id)

                let country = document.createElement("td")
                country.id = "country" + v
                country.style.width = "100px"
                country.style.maxWidth = "100px"
                country.className = "clickEdit"
                if (v != flag) {
                    country.addEventListener('click', function () { flag = this.id.slice(-1); get() })
                    let flagDiv = document.createElement("div")
                    flagDiv.style.backgroundImage = "url('gfx/" + countryTable[k.country] + ".JPG')"
                    flagDiv.id = "flag" + v
                    flagDiv.style.height = "50px"
                    flagDiv.style.width = "75px"
                    flagDiv.style.margin = "0 auto"
                    flagDiv.style.backgroundSize = "75px 50px"
                    country.append(flagDiv)
                } else {
                    country.addEventListener('click', function (e) { if (e.target == this) { flag = -1; get() } })
                    country.style.backgroundColor = "#FFFFFF"
                    let country_input = document.createElement("select")
                    country_input.id = "mod-country-input"
                    for (let i in countryTable) {
                        let country_option = document.createElement("option")
                        country_option.value = i
                        country_option.innerHTML = countryTable[i]
                        if (i == k.country) country_option.selected = true
                        country_input.append(country_option)
                    }
                    country.append(country_input)
                }
                tr.append(country)

                let denom = document.createElement("td")
                denom.style.width = "80px"
                denom.style.maxWidth = "80px"
                denom.id = "denom" + v
                if (v != flag) {
                    denom.innerHTML = k.denom
                } else {
                    denom.style.backgroundColor = "#FFFFFF"
                    let denom_input = document.createElement("input")
                    denom_input.id = "mod-denom-input"
                    denom_input.value = k.denom
                    denom.append(denom_input)
                }
                tr.append(denom)

                let cat_number = document.createElement("td")
                cat_number.style.width = "100px"
                cat_number.style.maxWidth = "100px"
                cat_number.id = "cat_number" + v
                if (v != flag) {
                    cat_number.innerHTML = k.cat_number
                } else {
                    cat_number.style.backgroundColor = "#FFFFFF"
                    let cat_number_input = document.createElement("input")
                    cat_number_input.id = "mod-cat_number-input"
                    cat_number_input.value = k.cat_number
                    cat_number.append(cat_number_input)
                }
                tr.append(cat_number)

                let alloy = document.createElement("td")
                alloy.style.width = "100px"
                alloy.style.maxWidth = "100px"
                alloy.id = "alloy" + v
                if (v != flag) {
                    alloy.innerHTML = alloyTable[k.alloy]
                } else {
                    alloy.style.backgroundColor = "#FFFFFF"
                    let alloy_input = document.createElement("select")
                    alloy_input.id = "mod-alloy-input"
                    alloy_input.style.width = "80%"
                    for (let i in alloyTable) {
                        let alloy_option = document.createElement("option")
                        alloy_option.value = i
                        alloy_option.innerHTML = alloyTable[i]
                        if (i == k.alloy) alloy_option.selected = true
                        alloy_input.append(alloy_option)
                    }
                    alloy.append(alloy_input)
                }
                tr.append(alloy)

                let date = document.createElement("td")
                date.style.width = "80px"
                date.style.maxWidth = "80px"
                date.id = "date" + v
                if (v != flag) {
                    date.innerHTML = k.date
                } else {
                    date.style.backgroundColor = "#FFFFFF"
                    let date_input = document.createElement("input")
                    date_input.id = "mod-date-input"
                    date_input.value = k.date
                    date.append(date_input)
                }
                tr.append(date)

                let captchaCont = document.createElement("td")
                captchaCont.style.width = "80px"
                captchaCont.style.maxWidth = "80px"
                captchaCont.id = "captchaCont" + v
                let captcha = document.createElement("input")
                if (v != flag) {
                    captcha.id = "captcha" + v
                } else {
                    captcha.id = "mod-captcha"
                }
                captchaCont.append(captcha)
                tr.append(captchaCont)

                let delCont = document.createElement("td")
                delCont.style.width = "50px"
                delCont.style.maxWidth = "50px"
                delCont.id = "delCont" + v
                if (v != flag) {
                    let delButton = document.createElement("button")
                    delButton.id = "delButton" + v
                    delButton.className = "delButton"
                    delButton.addEventListener("click", function () { delAction(document.getElementById('id' + this.id.slice(-1)).value, this.id.slice(-1)) })
                    delCont.append(delButton)
                } else {
                    delCont.style.backgroundColor = "#FFFFFF"
                    let delButton = document.createElement("button")
                    delButton.id = "modButton" + v
                    delButton.className = "modButton"
                    delButton.addEventListener("click", function () { modAction(document.getElementById('id' + this.id.slice(-1)).value) })
                    delCont.append(delButton)
                }
                tr.append(delCont)
            })


            tr = document.createElement("tr")
            tr.className = "ctrls"
            table.append(tr)

            let ctrls_header = document.createElement("td")
            ctrls_header.innerHTML = "ADD NEW RECORD"
            ctrls_header.colSpan = 7
            tr.append(ctrls_header)


            tr = document.createElement("tr")
            tr.className = "ctrls"
            table.append(tr)

            let id = document.createElement("input")
            id.id = "edit-id"
            id.type = "hidden"
            tr.append(id)

            let country = document.createElement("td")
            country.id = "edit-country"
            let country_input = document.createElement("select")
            country_input.id = "edit-country-input"
            for (let i in countryTable) {
                let country_option = document.createElement("option")
                country_option.value = i
                country_option.innerHTML = countryTable[i]
                country_input.append(country_option)
            }
            country.append(country_input)
            tr.append(country)

            let denom = document.createElement("td")
            denom.id = "edit-denom"
            let denom_input = document.createElement("input")
            denom_input.id = "edit-denom-input"
            denom.append(denom_input)
            tr.append(denom)

            let cat_number = document.createElement("td")
            cat_number.id = "edit-cat_number"
            let cat_number_input = document.createElement("input")
            cat_number_input.id = "edit-cat_number-input"
            cat_number.append(cat_number_input)
            tr.append(cat_number)

            let alloy = document.createElement("td")
            alloy.id = "edit-alloy"
            let alloy_input = document.createElement("select")
            alloy_input.id = "edit-alloy-input"
            for (let i in alloyTable) {
                let alloy_option = document.createElement("option")
                alloy_option.value = i
                alloy_option.innerHTML = alloyTable[i]
                alloy_input.append(alloy_option)
            }
            alloy.append(alloy_input)
            tr.append(alloy)

            let date = document.createElement("td")
            date.id = "edit-date"
            let date_input = document.createElement("input")
            date_input.id = "edit-date-input"
            date.append(date_input)
            tr.append(date)

            let captchaCont = document.createElement("td")
            captchaCont.id = "edit-captchaCont"
            let captcha = document.createElement("input")
            captcha.id = "edit-captcha"
            captchaCont.append(captcha)
            tr.append(captchaCont)

            let delCont = document.createElement("td")
            delCont.id = "edit-delCont"
            let delButton = document.createElement("button")
            delButton.innerHTML = "ADD"
            delButton.className = "addButton"
            delButton.addEventListener("click", addAction)
            delCont.append(delButton)
            tr.append(delCont)
        }
    }

    xhttp.send("acc=get")
}
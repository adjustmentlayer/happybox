var areaSelect = document.querySelector("#selectAreas");
var settlementSelect = document.querySelector("#selectSettlements");
var warehouseSelect = document.querySelector("#selectWarehouses");
// Получить спинер
var spinner = document.querySelector(".spinner");
function showSpinner(){
    spinner.style.display = "flex";
}

function hideSpinner(){
    spinner.style.display = "none";
}
function getAreas() {
    
    showSpinner();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/js/areas.json', true);    
    xhr.setRequestHeader('Content-type','application/json');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && xhr.status ==200) {
            var result = xhr.responseText;
            var json = JSON.parse(result);
            for(var i =0;i<json.length;i++){
                var areaName = json[i]['name'];
                var areaRef = json[i]['areaRef'];
                var totalAmount = json[i]['totalAmount'];
                var page = json[i]['page'];
                areaSelect.innerHTML += "<option value='"+areaName+"' data-area='"+areaRef+"' data-limit='"+totalAmount+"'data-page='"+page+"'>"+areaName+ "</option>";
            }
            hideSpinner();
        }
    };
    xhr.send(false);
    
}
function getSettlements(){
    showSpinner();
    warehouseSelect.innerHTML = "";
    settlementSelect.innerHTML = "<option disabled selected value='not_selected'>Оберіть населенный пункт</option>";
    
        var areaRef = areaSelect.options[areaSelect.selectedIndex].dataset.area;
        var limit = areaSelect.options[areaSelect.selectedIndex].dataset.limit;
        var page = Number(areaSelect.options[areaSelect.selectedIndex].dataset.page);

        var url = "/novaposhta/getSettlements";
        
        var settings = {
            'apiKey':'',
            'modelName':'AddressGeneral',
            'calledMethod':'getSettlements',
            'methodProperties': {
                'AreaRef': areaRef,
                'Warehouse': '1',
                'Page': page
            }
        }
        var s_settings = "settings="+JSON.stringify(settings);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);    
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded; charset=UTF-8');
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 4 && xhr.status ==200) {
                var result = xhr.responseText;
                var json = JSON.parse(result);
                if(json ==null){
                    alert("Ошибка! Попробуйте еще раз!");
                    areaSelect.selectedIndex = 0;
                }else{
                    for(var i =0;i<json.length;i++){
                        var description = json[i]['Description'];
                        var ref = json[i]['Ref'];
                        settlementSelect.innerHTML += "<option value='"+description+"' data-ref='"+ref+"'>"+description+ "</option>";
                    }
                }
                hideSpinner();
            }
            
        };
        xhr.send(s_settings);
        
        
}

function getWarehouses(){
    showSpinner();
    warehouseSelect.innerHTML = "<option disabled selected value='not_selected'>Оберіть відділення</option>";
    
    var ref = settlementSelect.options[settlementSelect.selectedIndex].dataset.ref;

    var settings = {
        'apiKey':'',
        'modelName':'Address',
        'calledMethod':'getWarehouses',
        'methodProperties': {
            'SettlementRef':ref,
            'Page': 1
        }
    }
    var s_settings = "settings="+JSON.stringify(settings);
    var url = "/novaposhta/getWarehouses";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);    
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded; charset=UTF-8');
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && xhr.status ==200) {
            var result = xhr.responseText;
            var json = JSON.parse(result);
            if(json ==null){
                alert("Ошибка! Попробуйте еще раз!");
                warehouseSelect.selectedIndex = 0;
            }else{
                
                if(json.length ==0){
                    warehouseSelect.innerHTML="<option disabled selected value='not_found'>Відділення не знайдені</option>";
                }else{
                    for(var i =0;i<json.length;i++){
                        var description = json[i]['Description'];
                        var ref = json[i]['ref'];
                        warehouseSelect.innerHTML += "<option value='"+description+"'>"+description+ "</option>";
                    }
                }
                
            }
            hideSpinner();
        }
    };
    xhr.send(s_settings);
    
}



window.addEventListener("load", getAreas);
areaSelect.addEventListener("change", getSettlements);
settlementSelect.addEventListener("change", getWarehouses);
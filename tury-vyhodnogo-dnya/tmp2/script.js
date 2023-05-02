function getElementByXPath(xpath) {
  return new XPathEvaluator()
    .createExpression(xpath)
    .evaluate(document, XPathResult.FIRST_ORDERED_NODE_TYPE)
    .singleNodeValue
};

var trip =  getElementByXPath("/html/body/section[1]/div[1]/div[2]/div[1]/div/div/h1").textContent; // трип

var day = getElementByXPath("/html/body/section[1]/div[1]/div[2]/div[2]/div[1]/div/div[1]/span[1]").textContent; // 29

var monthName  =  getElementByXPath("/html/body/section[1]/div[1]/div[2]/div[2]/div[1]/div/div[1]/span[2]").textContent; // апр


// Объект, связывающий названия месяцев с их номерами
const monthMap = {
    'янв': '01',
    'фев': '02',
    'мар': '03',
    'апр': '04',
    'май': '05',
    'июн': '06',
    'июл': '07',
    'авг': '08',
    'сен': '09',
    'окт': '10',
    'ноя': '11',
    'дек': '12'
  };
  
  const month = monthMap[monthName];
  
  const formattedDate = [day, month].join('.');
  console.log(formattedDate); // Выведет "29.04"
  

var test = new XMLHttpRequest();
test.open("GET", "http://stavturist.local/bronev/in.html", false);
test.send();
var TDOC = test.responseText;

// Создаем парсер для HTML-кода
var parser = new DOMParser();

// Разбираем HTML-код и создаем DOM-структуру
var doc = parser.parseFromString(TDOC, "text/html");

// Находим элемент по id
var elementById = doc.getElementById('__BVID__111');


var table = elementById;
var rows = table.getElementsByTagName("tr");
for (var i = 0; i < rows.length; i++) {
  var cells = rows[i].getElementsByTagName("td");
  for (var j = 0; j < cells.length; j++) {
    
    if (j == 0)
    {
        var nameTD = cells[j].innerHTML;
        var PnameTD = parser.parseFromString(nameTD, "text/html");
        var bTag = PnameTD.querySelector('b');
        var text = bTag.textContent.trim();

        //console.log(i + " : NAME : " +  text);
        var date_tmp = rows[i].getElementsByTagName("td")[1].innerHTML;
        const date = date_tmp.slice(0, 5); // "20.05"
        if (text == trip & date == formattedDate){
            console.log(trip + " " + i + " " + rows[i].getElementsByTagName("td")[3].innerHTML);
            
            // Получаем элемент по XPath
            const element = document.evaluate("/html/body/section[1]/div[1]/div[2]/div[2]/div[2]/div/form/div[1]/div[1]/span[2]", document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;

            // Изменяем содержимое элемента
            element.innerHTML = rows[i].getElementsByTagName("td")[3].innerHTML;

        }
    };
  }
}

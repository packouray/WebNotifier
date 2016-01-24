<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <script type="text/javascript">
      //notif sur firefox
      function notifyMe() {
                if (navigator.userAgent.indexOf("Firefox") != -1) {
                    var id_notif_comm = document.getElementById("id_notif_comm").value;
                    var id_notif_mess = document.getElementById("id_notif_mess").value;
                    var id_notif_reto = document.getElementById("id_notif_reto").value;
                    var id_notif_ots = document.getElementById("id_notif_ots").value;
                    var id_notif_cus = document.getElementById("id_notif_cus").value;
                    var tab = [id_notif_comm, id_notif_mess, id_notif_reto, id_notif_ots, id_notif_cus], i;
                    Array.prototype.inArray = function() {
                      for (var i = 0; i < this.length; i++) {
                        if (this[i] == 1) {
                          //variables affichage notif
                          var json = JSON.parse(document.getElementById("orders_content").value);
                          var domain = document.getElementById("domain_name").value;
                          var admin = document.getElementById("admin_dir").value;
                          var panier = "http://"+domain+"/modules/webnotification/img/orders_icon/commande.png";
                          //texte
                          var today = "{l s='Today' mod='webnotification'}";
                          var product = "{l s='Product(s):' mod='webnotification'}";
                          // check si le navigateur supporte les notifications
                          if (!("Notification" in window)) {
                            alert("Ce navigateur ne supporte pas les notifications desktop");
                          }
                          //OK pour recevoir des notifications
                          else if (Notification.permission === "granted") {
                            for (var a = 0; a < this.length; a++) {
                              var notification = new Notification('+'+json[a].price+' '+json[a].devise+':'+json[a].sum+' '+json[a].devise+' '+today, {
                                icon: ''+panier,
                                body: ''+product+' '+json[a].contenu
                                }
                              );
                              notification.onclick = function () {
                                 window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminOrders&id_order="+json[a].id_order+"&vieworder&token=ec09932f900ff14abffb8d7377bdbc38");
                              }
                            }
                            notification.show();
                          }
                          else if (Notification.permission !== "denied") {
                            Notification.requestPermission(function (permission) {
                              if(!("permission" in Notification)) {
                                Notification.permission = permission;
                              }
                              if (permission === "granted") {
                                for (var a = 0; a < this.length; a++) {
                                  var notification = new Notification('+'+json[a].price+' '+json[a].devise+':'+json[a].sum+' '+json[a].devise+' '+today, {
                                    body: ''+product+' '+json[a].contenu,
                                    icon: ''+panier
                                    }
                                  );
                                  notification.onclick = function () { 
                                    window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminOrders&id_order="+json[a].id_order+"&vieworder&token=ec09932f900ff14abffb8d7377bdbc38");
                                  }
                                }
                                notification.show();
                              }
                            });
                          }
                        }
                        if (this[i] == 2) {
                          var json = JSON.parse(document.getElementById("returns_content").value)
                          var domain = document.getElementById("domain_name").value;
                          var admin = document.getElementById("admin_dir").value;
                          //texte
                          var _return = "{l s='RETURN N°' mod='webnotification'}";
                          var contenu = "{l s='CONTENT:' mod='webnotification'}";
                          var motif = "{l s='CAUSE:' mod='webnotification'}";
                            // check si le navigateur supporte les notifications
                            if (!("Notification" in window)) {
                              alert("Ce navigateur ne supporte pas les notifications desktop");
                            }
                            //OK pour recevoir des notifications
                            else if (Notification.permission === "granted") {
                              for (var a = 0; a < json.length; a++) {
                                var notification = new Notification(''+_return+' '+json[a].id_return, {
                                  icon: "http://"+domain+"/modules/webnotification/img/returns_icon/retourimg.jpg",
                                  body: ''+contenu+' '+json[a].contenu+'\n'+motif+' '+json[a].cause
                                  }
                                );
                                notification.onclick = function () { 
                                       window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminReturn&id_order_return="+json[a].id_return+"&updateorder_return&token=232f328e868a8bb41ae5017b6a272616");
                                }
                              }
                              notification.show();
                            }
                            else if (Notification.permission !== "denied") {
                              Notification.requestPermission(function (permission) {
                                if(!("permission" in Notification)) {
                                  Notification.permission = permission;
                                }
                                if (permission === "granted") {
                                  for (var a = 0; a < json.length; a++) {
                                    var notification = new Notification(''+_return+' '+json[a].id_return, {
                                      body: ''+contenu+' '+json[a].contenu+'\n'+motif+' '+json[a].cause,
                                      icon: "http://"+domain+"/modules/webnotification/img/returns_icon/retourimg.jpg"
                                      }
                                    );
                                    notification.onclick = function () { 
                                       window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminReturn&id_order_return="+json[a].id_return+"&updateorder_return&token=232f328e868a8bb41ae5017b6a272616");
                                    }
                                  }
                                  notification.show();
                                }
                              });
                            }
                        }
                        if (this[i] == 3) {
                          var json = JSON.parse(document.getElementById("messages_content").value);
                          var domain = document.getElementById("domain_name").value;
                          var admin = document.getElementById("admin_dir").value;
                          // check si le navigateur supporte les notifications
                          if (!("Notification" in window)) {
                            alert("Ce navigateur ne supporte pas les notifications desktop");
                          }
                          //OK pour recevoir des notifications
                          else if (Notification.permission === "granted") {
                            for (var a = 0; a < json.length; a++) {
                              var notification = new Notification(''+json[a].customer, {
                                icon: "http://"+domain+"/modules/webnotification/img/messages_icon/message.JPG",
                                body: ''+json[a].message
                                }
                              );
                              notification.onclick = function () { 
                                     window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminCustomerThreads&id_customer_thread="+json[a].id_customer_thread+"&viewcustomer_thread&token=3fe3a72c809eee5b273f8d1b66d3b7ee");
                                  }
                              }
                              notification.show();
                          }
                          else if (Notification.permission !== "denied") {
                            Notification.requestPermission(function (permission) {
                              if(!("permission" in Notification)) {
                                Notification.permission = permission;
                              }
                              if (permission === "granted") {
                                for (var a = 0; a < json.length; a++) {
                                  var notification = new Notification(''+json[a].customer, {
                                    body: ''+json[a].message,
                                    icon: "http://"+domain+"/modules/webnotification/img/messages_icon/message.JPG"
                                    }
                                  );
                                  notification.onclick = function () { 
                                     window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminCustomerThreads&id_customer_thread="+json[a].id_customer_thread+"&viewcustomer_thread&token=3fe3a72c809eee5b273f8d1b66d3b7ee");
                                  }
                                }
                                notification.show();
                              }
                            });
                          }
                        }
                        if (this[i] == 4) {
                          var json = JSON.parse(document.getElementById("ots_content").value);
                          var domain = document.getElementById("domain_name").value;
                          //traduction
                          var title = "{l s='OUT OF STOCK !!' mod='webnotification'}";
                          var quantity_text = "{l s='*Quantity : ' mod='webnotification'}";
                          // check si le navigateur supporte les notifications
                          if (!("Notification" in window)) {
                            alert("Ce navigateur ne supporte pas les notifications desktop");
                          }
                          else if (Notification.permission === "granted") {
                            for (var a = 0; a < json.length; a++) {
                              var notification = new Notification(''+title, {
                                icon: "http://"+domain+"/modules/webnotification/img/outofstock_icon/ots.png",
                                body: ''+json[a].produit+'\n'+quantity_text+json[a].quantity
                                }
                              );
                            }
                            notification.show();
                          }
                          else if (Notification.permission !== "denied") {
                            Notification.requestPermission(function (permission) {
                              if(!("permission" in Notification)) {
                                Notification.permission = permission;
                              }
                              if (permission === "granted") {
                                for (var a = 0; a < json.length; a++) {
                                  var notification = new Notification(''+title, {
                                    body: ''+json[a].produit+'\n'+quantity_text+json[a].quantity,
                                    icon: "http://"+domain+"/modules/webnotification/img/outofstock_icon/ots.png"
                                    }
                                  );
                                }
                                notification.show();
                              }
                            });
                          }
                        }
                        if (this[i] == 5) {
                          var json = JSON.parse(document.getElementById("customers_content").value);
                          var domain = document.getElementById("domain_name").value;
                          var admin = document.getElementById("admin_dir").value;
                          //traduction
                          var title = "{l s='NEW CUSTOMER ACCOUNT' mod='webnotification'}";
                          var email_str = "{l s='Email : ' mod='webnotification'}";
                          var customer_str = "{l s='Customer name : ' mod='webnotification'}";
                          var nb_customers_str = "{l s='Shop\'s customers account : ' mod='webnotification'}";
                          // check si le navigateur supporte les notifications
                          if (!("Notification" in window)) {
                            alert("Ce navigateur ne supporte pas les notifications desktop");
                          }
                          else if (Notification.permission === "granted") {
                            for (var a = 0; a < json.length; a++) {
                              var notification = new Notification(''+title, {
                                icon: "http://"+domain+"/modules/webnotification/img/customers_icon/new_client.gif",
                                body: ''+nb_customers_str+json[a].nb_customers+'\r'+customer_str+json[a].info_customer+'\r'+email_str+json[a].email
                                }
                              );
                              notification.onclick = function () { 
                                window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminCustomers&id_customer="+json[a].id_customer+"&viewcustomer&token=d382e4f28e0eaf82a077893826fca6e8");
                              }
                            }
                            notification.show();
                          }
                          else if (Notification.permission !== "denied") {
                            Notification.requestPermission(function (permission) {
                              if(!("permission" in Notification)) {
                                Notification.permission = permission;
                              }
                              if (permission === "granted") {
                                for (var a = 0; a < json.length; a++) {
                                  var notification = new Notification(''+title, {
                                    body: ''+nb_customers_str+json[a].nb_customers+'\n'+customer_str+json[a].info_customer+'\n'+email_str+json[a].email,
                                    icon: "http://"+domain+"/modules/webnotification/img/customers_icon/new_client.gif"
                                    }
                                  );
                                  notification.onclick = function () { 
                                     window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminCustomers&id_customer="+json[a].id_customer+"&viewcustomer&token=d382e4f28e0eaf82a077893826fca6e8");
                                  }
                                }
                                notification.show();
                              }
                            });
                          }
                        }
                      }
                    }
                  }
              tab.inArray();
              document.getElementById("id_notif_reto").value = "";
              document.getElementById("id_notif_mess").value = "";
              document.getElementById("id_notif_comm").value = "";
              document.getElementById("id_notif_ots").value = "";
              document.getElementById("id_notif_cus").value = "";
            }

            //notif sur chrome et safari
            function show(){
              if(navigator.userAgent.indexOf("Chrome") != -1) {
                var id_notif_comm = document.getElementById("id_notif_comm").value;
                var id_notif_mess = document.getElementById("id_notif_mess").value;
                var id_notif_reto = document.getElementById("id_notif_reto").value;
                var id_notif_ots = document.getElementById("id_notif_ots").value;
                var id_notif_cus = document.getElementById("id_notif_cus").value;
                var tab = [id_notif_comm, id_notif_mess, id_notif_reto, id_notif_ots, id_notif_cus], i;
                Array.prototype.inArray = function() {
                  for (var i = 0; i < this.length; i++) {
                    if (this[i] == 1) {
                      //variables affichage notif
                      var json = JSON.parse(document.getElementById("orders_content").value);
                      var domain = document.getElementById("domain_name").value;
                      var admin = document.getElementById("admin_dir").value;
                      var panier = "http://"+domain+"/modules/webnotification/img/orders_icon/commande.png";
                      //texte
                      var today = "{l s='Today' mod='webnotification'}";
                      var product = "{l s='Product(s):' mod='webnotification'}";
                      if (window.webkitNotifications) {
                            if (window.webkitNotifications.checkPermission() == 0) {
                              for (var a = 0; a < json.length; a++) {
                                var n = window.webkitNotifications.createNotification(''+panier, '+'+json[a].price+' '+json[a].devise+': '+json[a].sum+' '+json[a].devise+' '+today, ''+product+' '+json[a].contenu);
                                n.onclick = function () {
                                  window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminOrders&id_order="+json[a].id_order+"&vieworder&token=ec09932f900ff14abffb8d7377bdbc38");
                                }
                                n.show();
                              }
                              document.getElementById("id_notif_comm").value = "";
                            }
                            else {
                              simulate(document.getElementById("request"), "click");
                            }
                      }
                      else {
                        return;
                      }
                    }
                    if (this[i] == 2) {
                      var json = JSON.parse(document.getElementById("returns_content").value)
                      var domain = document.getElementById("domain_name").value;
                      var admin = document.getElementById("admin_dir").value;
                      //texte
                      var _return = "{l s='RETURN N°' mod='webnotification'}";
                      var contenu = "{l s='CONTENT:' mod='webnotification'}";
                      var motif = "{l s='CAUSE:' mod='webnotification'}";
                      if (window.webkitNotifications) {
                            if (window.webkitNotifications.checkPermission() == 0) {
                              for (var a = 0; a < json.length; a++) {
                                var n = window.webkitNotifications.createNotification("http://"+domain+"/modules/webnotification/img/returns_icon/retourimg.jpg", ''+_return+' '+json[a].id_return, ''+contenu+' '+json[a].contenu+'\n'+motif+' '+json[a].cause);
                                 n.onclick = function () {
                                  window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminReturn&id_order_return="+json[a].id_return+"&updateorder_return&token=232f328e868a8bb41ae5017b6a272616");
                                }
                                n.show();
                              }
                              document.getElementById("id_notif_reto").value = "";
                            }
                            else {
                              simulate(document.getElementById("request"), "click");
                            }
                      }
                      else {
                        return;
                      }
                    }
                    if (this[i] == 3) {
                      var json = JSON.parse(document.getElementById("messages_content").value);
                      var domain = document.getElementById("domain_name").value;
                      var admin = document.getElementById("admin_dir").value;
                      if (window.webkitNotifications) {
                            if (window.webkitNotifications.checkPermission() == 0) {
                              for (var a = 0; a < json.length; a++) {
                                var n = window.webkitNotifications.createNotification("http://"+domain+"/modules/webnotification/img/messages_icon/message.JPG", ''+json[a].customer, ''+json[a].message);
                                n.onclick = function () {
                                  window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminCustomerThreads&id_customer_thread="+json[a].id_customer_thread+"&viewcustomer_thread&token=3fe3a72c809eee5b273f8d1b66d3b7ee");
                                }
                                n.show();
                              }
                              document.getElementById("id_notif_mess").value = "";
                            }
                            else {
                              simulate(document.getElementById("request"), "click");
                            }
                      }
                      else {
                        return;
                      }
                    }
                    if (this[i] == 4) {
                      var json = JSON.parse(document.getElementById("ots_content").value);
                      var domain = document.getElementById("domain_name").value;
                      //traduction
                      var title = "{l s='OUT OF STOCK !!' mod='webnotification'}";
                      var quantity_text = "{l s='*Quantity : ' mod='webnotification'}";
                      if (window.webkitNotifications) {
                        if (window.webkitNotifications.checkPermission() == 0){
                          for (var a = 0; a < json.length; a++) {
                            var n = window.webkitNotifications.createNotification("http://"+domain+"/modules/webnotification/img/outofstock_icon/ots.png", ''+title, ''+json[a].produit+'\n'+quantity_text+json[a].quantity);
                            n.show();
                          }
                          document.getElementById("id_notif_ots").value = "";
                        }
                        else {
                          simulate(document.getElementById("request"), "click");
                        }
                      }
                      else {
                        return;
                      }
                    }
                    if (this[i] == 5) {
                      var json = JSON.parse(document.getElementById("customers_content").value);
                      var domain = document.getElementById("domain_name").value;
                      var admin = document.getElementById("admin_dir").value;
                      //traduction
                      var title = "{l s='NEW CUSTOMER ACCOUNT' mod='webnotification'}";
                      var email_str = "{l s='Email : ' mod='webnotification'}";
                      var customer_str = "{l s='Customer name : ' mod='webnotification'}";
                      var nb_customers_str = "{l s='Shop\'s customers account : ' mod='webnotification'}";
                      if (window.webkitNotifications) {
                        if (window.webkitNotifications.checkPermission() == 0){
                          for (var a = 0; a < json.length; a++) {
                            var n = window.webkitNotifications.createNotification("http://"+domain+"/modules/webnotification/img/customers_icon/new_client.gif", ''+title, ''+nb_customers_str+json[a].nb_customers+'\n'+customer_str+json[a].info_customer+'\n'+email_str+json[a].email);
                            n.onclick = function () {
                              window.open("http://"+domain+"/"+admin+"/index.php?controller=AdminCustomers&id_customer="+json[a].id_customer+"&viewcustomer&token=d382e4f28e0eaf82a077893826fca6e8");
                            }
                            n.show();
                          }
                          document.getElementById("id_notif_cus").value = "";
                        }
                        else {
                          simulate(document.getElementById("request"), "click");
                        }
                      }
                      else {
                        return;
                      }
                    }
                }
            }
          }
          tab.inArray();
        }
    </script>
    <script type="text/javascript">
      /*ma fonction AJAX chargée de load le JS dans la div et de l'executer à chaque fois qu'elle est appelée */
      //initialisation sur les differents navigateurs 
      function getXMLHttp()
      {
        var xmlHttp;

        try
        {
          //Firefox, Opera 8.0+, Safari
          xmlHttp_com_data = new XMLHttpRequest();
          xmlHttp_com_notif = new XMLHttpRequest();
          xmlHttp_mes_data = new XMLHttpRequest();
          xmlHttp_mes_notif = new XMLHttpRequest();
          xmlHttp_ret_data = new XMLHttpRequest();
          xmlHttp_ret_notif = new XMLHttpRequest();
          xmlHttp_ots_data = new XMLHttpRequest();
          xmlHttp_ots_notif = new XMLHttpRequest();
          xmlHttp_cus_data = new XMLHttpRequest();
          xmlHttp_cus_notif = new XMLHttpRequest();
        }
        catch(e)
        {
          //Internet Explorer
          try
          {
            xmlHttp_com_data = new ActiveXObject("Msxml2.XMLHTTP");
            xmlHttp_com_notif = new ActiveXObject("Msxml2.XMLHTTP");
            xmlHttp_mes_data = new ActiveXObject("Msxml2.XMLHTTP");
            xmlHttp_mes_notif = new ActiveXObject("Msxml2.XMLHTTP");
            xmlHttp_ret_data = new ActiveXObject("Msxml2.XMLHTTP");
            xmlHttp_ret_notif = new ActiveXObject("Msxml2.XMLHTTP");
            xmlHttp_ots_data = new ActiveXObject("Msxml2.XMLHTTP");
            xmlHttp_ots_notif = new ActiveXObject("Msxml2.XMLHTTP");
            xmlHttp_cus_data = new ActiveXObject("Msxml2.XMLHTTP");
            xmlHttp_cus_notif = new ActiveXObject("Msxml2.XMLHTTP");
          }
          catch(e)
          {
            try
            {
              xmlHttp_com_data = new ActiveXObject("Microsoft.XMLHTTP");
              xmlHttp_com_notif = new ActiveXObject("Microsoft.XMLHTTP");
              xmlHttp_mes_data = new ActiveXObject("Microsoft.XMLHTTP");
              xmlHttp_mes_notif = new ActiveXObject("Microsoft.XMLHTTP");
              xmlHttp_ret_data = new ActiveXObject("Microsoft.XMLHTTP");
              xmlHttp_ret_notif = new ActiveXObject("Microsoft.XMLHTTP");
              xmlHttp_ots_data = new ActiveXObject("Microsoft.XMLHTTP");
              xmlHttp_ots_notif = new ActiveXObject("Microsoft.XMLHTTP");
              xmlHttp_cus_data = new ActiveXObject("Microsoft.XMLHTTP");
              xmlHttp_cus_notif = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e)
            {
              return false;
            }
          }
        }
        var tab = [xmlHttp_com_data, xmlHttp_com_notif, xmlHttp_mes_data, xmlHttp_mes_notif, xmlHttp_ret_data, xmlHttp_ret_notif, xmlHttp_ots_data, xmlHttp_ots_notif, xmlHttp_cus_data, xmlHttp_cus_notif]
        return tab;
      }
      //lance la requette AJAX
      function MakeRequest()
      {
        var get_objecttab = getXMLHttp();
        var xmlHttp_com_data = get_objecttab[0];
        var xmlHttp_mes_data = get_objecttab[2];
        var xmlHttp_ret_data = get_objecttab[4];
        var xmlHttp_ots_data = get_objecttab[6];
        var xmlHttp_cus_data = get_objecttab[8];
        var domain = document.getElementById("domain_name").value;

        ajax_commande_data(xmlHttp_com_data, domain);
        ajax_retour_data(xmlHttp_ret_data, domain);
        ajax_message_data(xmlHttp_mes_data, domain);
        ajax_ots_data(xmlHttp_ots_data, domain);
        ajax_cus_data(xmlHttp_cus_data, domain);
      }
      function ajax_commande_notif(xmlHttp, domain)
      {
        xmlHttp.onreadystatechange = function()
        {
          if (xmlHttp.readyState == 4)
          {
            document.getElementById('run_notif').innerHTML = xmlHttp.responseText;
            if (xmlHttp.responseText != ''){
              var ob = document.getElementById("sc").text;
              if(ob != '') {
               eval(ob.toString());
              }
            }
          }
        }
        xmlHttp.open("GET", "http://"+domain+"/modules/webnotification/notif.php", true); 
        xmlHttp.send(null);
      }
      function ajax_message_notif(xmlHttp, domain)
      {
        xmlHttp.onreadystatechange = function()
        {
          if (xmlHttp.readyState == 4)
          {
            document.getElementById('run_notif2').innerHTML = xmlHttp.responseText;
            if (xmlHttp.responseText != ''){
              var ob = document.getElementById("sc2").text;
              if(ob != '') {
               eval(ob.toString());
              }
            }
          }
        }
        xmlHttp.open("GET", "http://"+domain+"/modules/webnotification/notif_message.php", true); 
        xmlHttp.send(null);
      }
      function ajax_retour_notif(xmlHttp, domain)
      {
        xmlHttp.onreadystatechange = function()
        {
          if (xmlHttp.readyState == 4)
          {
            document.getElementById('run_notif3').innerHTML = xmlHttp.responseText;
            if (xmlHttp.responseText != ''){
              var ob = document.getElementById("sc3").text;
              if(ob != '') {
               eval(ob.toString());
              }
            }
          }
        }
        xmlHttp.open("GET", "http://"+domain+"/modules/webnotification/notif_return.php", true); 
        xmlHttp.send(null);
      }
      function ajax_ots_notif(xmlHttp, domain)
      {
        xmlHttp.onreadystatechange = function()
        {
          if (xmlHttp.readyState == 4)
          {
            document.getElementById('run_notif4').innerHTML = xmlHttp.responseText;
            if (xmlHttp.responseText != ''){
              var ob = document.getElementById("sc4").text;
              if(ob != '') {
               eval(ob.toString());
              }
            }
          }
        }
        xmlHttp.open("GET", "http://"+domain+"/modules/webnotification/notif_ots.php", true); 
        xmlHttp.send(null);
      }
      function ajax_cus_notif(xmlHttp, domain)
      {
        xmlHttp.onreadystatechange = function()
        {
          if (xmlHttp.readyState == 4)
          {
            document.getElementById('run_notif5').innerHTML = xmlHttp.responseText;
            if (xmlHttp.responseText != ''){
              var ob = document.getElementById("sc5").text;
              if(ob != '') {
               eval(ob.toString());
              }
            }
          }
        }
        xmlHttp.open("GET", "http://"+domain+"/modules/webnotification/notif_customer.php", true); 
        xmlHttp.send(null);
      }
      function ajax_commande_data(xmlHttp, domain)
      {
        xmlHttp.onreadystatechange = function()
        {
          if (xmlHttp.readyState == 4)
          {
            if (xmlHttp.responseText != '') {
              var get_objecttab = getXMLHttp();
              var xmlHttp_com_notif = get_objecttab[1];
              var notif_type = JSON.parse(xmlHttp.responseText);
              document.getElementById("id_notif_comm").value = notif_type[0].id_notif_comm;
              document.getElementById("orders_content").value = xmlHttp.responseText;
              ajax_commande_notif(xmlHttp_com_notif, domain);
            }
          }
        }
        xmlHttp.open("GET", "http://"+domain+"/modules/webnotification/datas.php", true); 
        xmlHttp.send(null);
      }
      function ajax_message_data(xmlHttp, domain)
      {
        xmlHttp.onreadystatechange = function()
        {
          if (xmlHttp.readyState == 4)
          {
            if (xmlHttp.responseText != '') {
              var get_objecttab = getXMLHttp();
              var xmlHttp_mes_notif = get_objecttab[3];
              var notif_type = JSON.parse(xmlHttp.responseText);
              document.getElementById("id_notif_mess").value = notif_type[0].id_notif_mess;
              document.getElementById("messages_content").value = xmlHttp.responseText;
              ajax_message_notif(xmlHttp_mes_notif, domain);
            }
          }
        }
        xmlHttp.open("GET", "http://"+domain+"/modules/webnotification/messages_datas.php", true); 
        xmlHttp.send(null);
      }
      function ajax_retour_data(xmlHttp, domain)
      {
        xmlHttp.onreadystatechange = function()
        {
          if (xmlHttp.readyState == 4)
          {
            if (xmlHttp.responseText != '') {
              var get_objecttab = getXMLHttp();
              var xmlHttp_ret_notif = get_objecttab[5];
              var notif_type = JSON.parse(xmlHttp.responseText);
              document.getElementById("id_notif_reto").value = notif_type[0].id_notif_reto;
              document.getElementById("returns_content").value = xmlHttp.responseText;
              ajax_retour_notif(xmlHttp_ret_notif, domain);
            }
          }
        }
        xmlHttp.open("GET", "http://"+domain+"/modules/webnotification/returns_datas.php", true); 
        xmlHttp.send(null);
      }
      function ajax_ots_data(xmlHttp, domain)
      {
        xmlHttp.onreadystatechange = function()
        {
          if (xmlHttp.readyState == 4)
          {
            if (xmlHttp.responseText != '') {
              var get_objecttab = getXMLHttp();
              var xmlHttp_ots_notif = get_objecttab[7];
              var notif_type = JSON.parse(xmlHttp.responseText);
              document.getElementById("id_notif_ots").value = notif_type[0].id_notif_ots;
              document.getElementById("ots_content").value = xmlHttp.responseText;
              ajax_ots_notif(xmlHttp_ots_notif, domain);
            }
          }
        }
        xmlHttp.open("GET", "http://"+domain+"/modules/webnotification/ots_datas.php", true); 
        xmlHttp.send(null);
      }
      function ajax_cus_data(xmlHttp, domain)
      {
        xmlHttp.onreadystatechange = function()
        {
          if (xmlHttp.readyState == 4)
          {
            if (xmlHttp.responseText != '') {
              var get_objecttab = getXMLHttp();
              var xmlHttp_cus_notif = get_objecttab[9];
              var notif_type = JSON.parse(xmlHttp.responseText);
              document.getElementById("id_notif_cus").value = notif_type[0].id_notif_cus;
              document.getElementById("customers_content").value = xmlHttp.responseText;
              ajax_cus_notif(xmlHttp_cus_notif, domain);
            }
          }
        }
        xmlHttp.open("GET", "http://"+domain+"/modules/webnotification/customer_datas.php", true); 
        xmlHttp.send(null);
      }
    </script>

    <script type="text/javascript">

      //fonction permettant la lecture du sons de la notification
      function play() {
        var audio = document.getElementById("audio1");
        audio.play();
      }

    </script>


    <script type="text/javascript">
    //cette fonction me sert à simuler des click pour activer les différents évenements liés à la notification.
    function simulate(element, eventName){
    var options = extend(defaultOptions, arguments[2] || {});
    var oEvent, eventType = null;

    for (var name in eventMatchers)
    {
        if (eventMatchers[name].test(eventName)) { eventType = name; break; }
    }

    if (!eventType)
        throw new SyntaxError('Only HTMLEvents and MouseEvents interfaces are supported');

    if (document.createEvent)
    {
        oEvent = document.createEvent(eventType);
        if (eventType == 'HTMLEvents')
        {
            oEvent.initEvent(eventName, options.bubbles, options.cancelable);
        }
        else
        {
            oEvent.initMouseEvent(eventName, options.bubbles, options.cancelable, document.defaultView,
            options.button, options.pointerX, options.pointerY, options.pointerX, options.pointerY,
            options.ctrlKey, options.altKey, options.shiftKey, options.metaKey, options.button, element);
        }
        element.dispatchEvent(oEvent);
    }
    else
    {
        options.clientX = options.pointerX;
        options.clientY = options.pointerY;
        var evt = document.createEventObject();
        oEvent = extend(evt, options);
        element.fireEvent('on' + eventName, oEvent);
    }
    return element;
}

function extend(destination, source) {
    for (var property in source)
      destination[property] = source[property];
    return destination;
}

var eventMatchers = {
    'HTMLEvents': /^(?:load|unload|abort|error|select|change|submit|reset|focus|blur|resize|scroll)$/,
    'MouseEvents': /^(?:click|dblclick|mouse(?:down|up|over|move|out))$/
}
var defaultOptions = {
    pointerX: 0,
    pointerY: 0,
    button: 0,
    ctrlKey: false,
    altKey: false,
    shiftKey: false,
    metaKey: false,
    bubbles: true,
    cancelable: true
}
    </script>
    
</head>
<body>

  <!--Dossier et URL-->
  <input type="hidden" id="admin_dir" value="{$admin_dir}">
  <input type="hidden" id="domain_name" value="{$domain_name}">
  
  <!--sons de la notification-->
  <audio id="audio1" src="mak.wav"></audio>
  <input type="button" id="start_audio" style="display:none" onClick="play()">

  <!--valeur interval entre notifs-->
  <input type="hidden" id="interval" value="{$interval}">

  <!-- données notif commande -->
  <input type="hidden" id="orders_content" value="">
  <input type="hidden" id="id_notif_comm" value="">

  <!-- données notif message -->
  <input type="hidden" id="messages_content" value="">
  <input type="hidden" id="id_notif_mess" value="">

  <!-- données notif client -->
  <input type="hidden" id="customers_content" value="">
  <input type="hidden" id="id_notif_cus" value="">

  <!-- données notif retour -->
  <input type="hidden" id="returns_content" value="">
  <input type="hidden" id="id_notif_reto" value="">

  <!-- données notif rupture de stock -->
  <input type="hidden" id="ots_content" value="">
  <input type="hidden" id="id_notif_ots" value="">

  <!--bouttons cachés qui me servent à declencher le mecanisme de la notif commande-->
  <input type="button" id="notify" style="display:none" onClick="notifyMe();">
  <input type="button" id="show" style="display:none" onClick="show();">
  <input type="button" id="request" style="display:none" onClick="window.webkitNotifications.requestPermission();">

  <!-- Lance la fonction executant les appels ajax -->
  <input type="button" id="ajax" style="display:none" onClick="MakeRequest();">

  <script type="text/javascript">
    //permet de lancer la fonction AJAX
    var interval = document.getElementById("interval").value;
    function execajax(){
      simulate(document.getElementById("ajax"), "click");
    }
    setInterval("execajax()", interval);
  </script>

  <!--div dans laquelle je load le script JS toutes les 3 secondes-->
  <div id='run_notif'></div>
  <div id='run_notif2'></div>
  <div id='run_notif3'></div>
  <div id='run_notif4'></div>
  <div id='run_notif5'></div>

</body>
</html>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* Script: en_lang.php
* 	English translation file
*	Romanian translation file
*
* Last edited:
*	26th November 2012
*   08 December 2012
*
* License:
*	GPL v3 or above
*/

/* I will thankful if you could help me translating this file to your language and email me at saleem@tecdiary.com */

#Header

$lang['home'] 							= "Home";
$lang['products'] 						= "Produse";
$lang['new_product'] 					= "Adauga Produs";
$lang['inventories']			 		= "Inventare";
$lang['new_inventory'] 					= "Adauga Inventar";
$lang['sales'] 							= "Vanzari";
$lang['new_invoice'] 					= "Adauga Factura";
$lang['payments'] 						= "Plati";
$lang['recurrence'] 					= "Repetare";
$lang['total_sales'] 					= "Total Vanzari";
$lang['people'] 						= "Utilizatori";
$lang['reports'] 						= "Rapoarte";
$lang['users'] 							= "Utilizatori";
$lang['new_user'] 						= "Adauga Utilizator";
$lang['setting'] 						= "Setari";
$lang['billers'] 						= "Vanzatori";
$lang['new_biller'] 					= "Adauga Vanzator";
$lang['suppliers'] 						= "Furnizori";
$lang['new_supplier'] 					= "Adauga Furnizor";
$lang['customers'] 						= "Clienti";
$lang['new_customer'] 					= "Adauga Client";
$lang['invoice_types'] 					= "Tip Factura";
$lang['add_invoice_type'] 				= "Adauga tip factura";
$lang['tax_rates'] 						= "TVA";
$lang['add_tax_rate'] 					= "Adauga TVA";
$lang['warehouses'] 					= "Gestiuni";
$lang['add_warehouse'] 					= "Adauga Gestiune";
$lang['payment_types'] 					= "Metode de plata";
$lang['backup_database'] 				= "Backup Database";
$lang['transfer_products'] 				= "Transfer de produse";
$lang['transfers'] 						= "Transferuri";
$lang['transfer_products_by_csv'] 		= "Transfer de produse by CSV";
$lang['logout'] 						= "Iesire";
$lang['login'] 							= "Autentificare";
$lang['search_by_description'] 			= "Cauta produse dupa nume...";
$lang['search'] 						= "Cauta";
$lang['change_password'] 				= "Schimba parola";
$lang['notifications'] 					= "Notificari";
$lang['current_password'] 				= "Parola Curenta";
$lang['new_password'] 					= "Parola noua (trebuie sa contina cel putin 8 caractere)";
$lang['confirm_password'] 				= "Confirmare Parola";
$lang['chnage_logo'] 					= "Schimba logoul din sistem";
$lang['products_report'] 				= "Raport Produse";
$lang['add_by_csv'] 					= "Adauga produse by CSV";
$lang['purchases_report'] 				= "Raport Intrari";
$lang['csv_inventory'] 					= "Adauga intrare by CSV";
$lang['sales_report'] 					= "Raport vanzari";
$lang['upload_biller_logo'] 			= "Adauga Logo pentru Vanzator";
$lang['install'] 						= "Treubie sa stergeti folderul 'install'";
$lang['purchases'] 						= "Intrari";
$lang['invoices'] 						= "Facturi";
$lang['invoice'] 						= "Factura";
$lang['product_alerts'] 				= "Alerta Produse";
$lang['settings'] 						= "Setari";
$lang['peoples'] 						= "Utilizatori";
$lang['system_setting'] 				= "Setari Sistem";
$lang['actions'] 						= "Actiuni";
$lang['access_denied'] 					=  "Acces restrictionat!";
$lang['welcome'] 						=  "Bine ai venit";
$lang['list_results'] 					= "Te rugam sa folosesti tabelul de mai jos pentru naviga sau a filtra rezultatele. Puteti descarca tebelul in format csv, excel si pdf.";

/* ------------------------------------------- Billers/Suppliers/Customers ------------------------------------------------------- */

$lang['name'] 							= "Nume";
$lang['email_address'] 					= "E-mail";
$lang['company'] 						= "Nume Firma";
$lang['cui'] 							= "CUI";
$lang['company_reg'] 					= "Nr. Reg. Com.";
$lang['cnp'] 							= "CNP";
$lang['serie'] 							= "Serie Buletin";
$lang['address'] 						= "Adresa";
$lang['city'] 							= "Oras";
$lang['state'] 							= "Judet";
$lang['postal_code'] 					= "Cod Postal";
$lang['country'] 						= "Tara";
$lang['phone'] 							= "Telefon";
$lang['logo'] 							= "Logo";
$lang['account_no'] 					= "Nr. Cont";
$lang['bank'] 							= "Suc. Banca";
$lang['invoice_footer'] 				= "Informatii aditionale sfarsit factura";

$lang['enter_info'] 					= "Va rugam sa introduceti informatiile de mai jos.";
$lang['update_info']					= "Va rugam sa actualizati informatiile de mai jos.";
$lang['skip'] 							= "Puteti folosi - pentru a nu lasa campul gol.";
$lang['biller_added'] 					= "Vanzatorul a fost adaugat cu succes";
$lang['add_biller'] 					= "Adauga Vanzator";
$lang['update_biller'] 					= "Actualizare Vanzator";
$lang['biller_updated'] 				= "Vanzatorul a fost acutalizat cu succes";
$lang['biller_deleted'] 				= "Vanzatorul a fost sters cu succes";
$lang['alert_x_biller'] 				= "Aveti de gand sa stergeti acest vanzator?. Apasati OK pentru a continua si Cancel pentru a va intoarce";
$lang['delete_biller'] 					= "Sterge Vanzator";
$lang['edit_biller'] 					= "Modifica Vanzator";
$lang['customer_added'] 				= "Clientul a fost adaugat cu succes";
$lang['add_customer'] 					= "Adauga Client";
$lang['update_customer'] 				= "Actualizare Client";
$lang['customer_updated'] 				= "Clientul a fost actualizat cu succes";
$lang['customer_deleted'] 				= "Clientul a fost sters cu succes";
$lang['alert_x_customer'] 				= "Aveti de gand sa stergeti acest client?. Apasati OK pentru a continua si Cancel pentru a va intoarce";
$lang['delete_customer'] 				= "Sterge Client";
$lang['edit_customer'] 					= "Modifica Client";
$lang['supplier_added'] 				= "Furnizorul a fost adaugat cu succes";
$lang['add_supplier'] 					= "Adauga Furnizor";
$lang['supplier'] 						= "Furnizor";
$lang['update_supplier'] 				= "Actualizare Furnizor";
$lang['supplier_updated'] 				= "Furnizorul a fost acutalizat cu succes";
$lang['supplier_deleted'] 				= "Furnizorul a fost sters cu succes";
$lang['alert_x_supplier'] 				= "Aveti de gand sa stergeti acest furnizor?. Apasati OK pentru a continua si Cancel pentru a va intoarce";
$lang['delete_supplier'] 				= "Sterge Furnizor";
$lang['edit_supplier'] 					= "Modifica Furnizor";

$lang['user_added'] 					= "Utilizatorul a fost adaugat cu succes";
$lang['add_user'] 						= "Adauga Utilizator";
$lang['update_user'] 					= "Actualizare Utilizator";
$lang['user_updated'] 					= "Utilizatorul a fost Actualizat cu succes";
$lang['user_deleted'] 					= "Utilizatorul a fost Sters cu succes";
$lang['alert_x_user'] 					= "Aveti de gand sa stergeti acest utilizator?. Apasati OK pentru a continua si Cancel pentru a va intoarce";
$lang['delete_user'] 					= "Sterge Utilizator";
$lang['edit_user'] 						= "Modifica Utilizator";
$lang['disabled_in_demo'] 				= "Aceasta functie este indisponibila in versiunea Demo";
$lang['old_pw'] 						= "Parola Veche";
$lang['new_pw'] 						= "Parola Noua";
$lang['confirm_pw'] 					= "Confirma Parola";
$lang['change_password'] 				= "Schimba Parola";
$lang['first_name'] 					= "Prenume";
$lang['last_name'] 						= "Nume";
$lang['pw'] 							= "Parola";
$lang['user_added'] 					= "Utilizatorul a fost a adaugat cu succes";
$lang['new_user'] 						= "Adauga utilizator nou";
$lang['user_role'] 						= "Drepturi";
$lang['enter_user_info'] 				= "Va rugam sa introduceti detaliile de utilzator mai jos";
$lang['update_user_info'] 				= "Va rugam sa actualizati detaliile de utilzator mai jos. Daca nu doriti sa schimbati parola, Lasati campul gol.";
$lang['owner_role'] 					= "<strong>Owner</strong> (Admin)";
$lang['admin_role'] 					= "<strong>Admin</strong> (Admin, dar nu poate crea utilizatori)";
$lang['salesman_role'] 					= "<strong>Sales Staff</strong> (Adauga facturi &amp; si vede tot)";
$lang['purchaser_role'] 				= "<strong>Purchase Staff </strong>(Adauga intrari &amp; si vede tot)";
$lang['view_role'] 						= "<strong>Viewer</strong> (Doar poate vizualiza)";
$lang['users'] 							= "Utilizatori";
$lang['login_to'] 						= "Autentificare pentru a gestiona stocul";
$lang['forgot_pw'] 						= "Ati uitat parola?";
$lang['remember_me'] 					= "Tine-ma minte";
$lang['back_to_login'] 					= "Inapoi la pagina de autentificare";
$lang['email_to_reset_pw'] 				= "Te rugam sa introduci adresa ta de email astfel încât sa putem trimite un e-mail pentru a reseta parola";
$lang['submit'] = "Submit";


$lang['purchase_orders'] 				= "Intrari";
$lang['no_zero_required'] 				= "Campurile %s sunt obligatorii";
$lang['ref_no'] 						= "Nr. Referinta";
$lang['date'] 							= "Data";
$lang['warehouse'] 						= "Gestiune";
$lang['quantity1'] 						= "Cantitate 1";
$lang['product1'] 						= "Produs 1";
$lang['unit_price1'] 					= "Pret Unitar 1";
$lang['note'] 							= "Nota";
$lang['purchase_added'] 				= "Intrarea a fost adaugata cu succes";
$lang['add_purchase'] 					= "Adauga Intrare";
$lang['upload_file'] 					= "Incarca Fisier";
$lang['purchase_updated'] 				= "Intrarea a fost actualizata cu succes";
$lang['update_purchase'] 				= "Actualizare Intrare";
$lang['not_allowed'] 					= "Actiune nu este permisa";
$lang['no'] 							= "Nr.";
$lang['unit_price'] 					= "Pret Unitar (Fara TVA)";
$lang['enter_inventory'] 				= "Va rugam introduceti detaliile de inventar mai jos";
$lang['product'] 						= "Produs";
$lang['add_row'] 						= "Adauga rand nou";
$lang['remove_row'] 					= "Sterge ultimul rand";
$lang['update_purchase'] 				= "Actualizare Intrare";
$lang['inventory_items'] 				= "Obiectelor de Inventar";
$lang['csv1'] 							= "Prima linea in fisierul csv trebuie sa ramana acolo. Va rugam nu modificati ordinea coloanelor.";
$lang['csv2'] 							= "Coloana corecta este";
$lang['csv3'] 							= "&amp; trebuie sa urmati acest.";
$lang['upload_csv'] 					= "Incarca fisier CSV";
$lang['no_file_selected'] 				= "Niciun fisier selectat";
$lang['choose_file'] 					= "Selecteaza fisier";
$lang['csv_file_tip'] 					= "Doar fisier .csv si Max. dimensiunea de 200 KB.";
$lang['total'] 							= "Total";
$lang['inventory'] 						= "Inventar";
$lang['view_inventory'] 				= "Vizualizare Inventar";
$lang['download_pdf'] 					= "Descarca PDF";
$lang['email_inventory'] 				= "Trimite inventar prin E-mail";
$lang['edit_inventory'] 				= "Modifica Inventar";
$lang['inventory_no'] 					= "Inventar Nr.";
$lang['description'] 					= "Descriere";
$lang['code'] 							= "Cod";
$lang['subtotal'] 						= "Subtotal";
$lang['total_amount'] 					= "Total";
$lang['tel'] 							= "Tel";
$lang['email'] 							= "E-mail";
$lang['email_details'] 					= "Va rugam introduceti detaliile despre email";
$lang['from'] 							= "De la";
$lang['to'] 							= "Catre";
$lang['subject'] 						= "Subiect";
$lang['message'] 						= "Mesaj";
$lang['optional'] 						= "Optional";
$lang['email_sent'] 					= "Email-ul a fost trimis cu succes";
$lang['inventory'] 						= "Inventar";

$lang['same_warehouse'] 				= "Nu sunt reguli pentru a transfera produs catre aceasi gestiune.";
$lang['quantity_transferred'] 			= "Cantitate produs transferat";
$lang['transfer_quantity'] 				= "Transfera Cantitate";
$lang['transfer_no'] 					= "Transfer Nr.";
$lang['warehouse_code'] 				= "Cod Gestiune";
$lang['product_name'] 					= "Nume Produs";
$lang['product_unit'] 					= "Unitate Produs";
$lang['product_cost'] 					= "Pret Unitar";
$lang['product_code'] 					= "Cod";
$lang['product_um'] 					= "U.M";
$lang['product_size'] 					= "Marime";
$lang['alert_quantity'] 				= "Alerta Cant.";
$lang['product_image'] 					= "Imagine";
$lang['product_added'] 					= "Produsul a fost adaugat cu succes";
$lang['add_product'] 					= "Adauga Produs";
$lang['product_updated'] 				= "Produsul a fost actualizat cu succes";
$lang['update_price'] 					= "Modifica pret";
$lang['update_price_csv'] 				= "Modificare lista de pret by CSV";
$lang['price_updated'] 					= "Price Successfully Updated";
$lang['update_product'] 				= "Update Product";
$lang['check_product_code']				= "Please check product code";
$lang['code_already_exist'] 			= "A product with same code already exist!";
$lang['code_x_exist'] 					= "System is unable to find the product with this code!";
$lang['products_added'] 				= "Products Successfully Added";
$lang['csv_add_products'] 				= "Upload CSV File to Add Products";
$lang['product_deleted'] 				= "Product Successfully Deleted";
$lang['transfers'] 						= "Transferuri";
$lang['transfer'] 						= "Transfer";
$lang['price'] 							= "Pret";
$lang['product_price'] 					= "Pret";
$lang['product_cost'] 					= "Pret de cost";
$lang['enter_product_info'] 			= "Va rugam introduceti informatiile produsului mai jos";
$lang['update_product_info'] 			= "Va rugam actualizati informatiile produsului mai jos";
$lang['size'] 							= "Marime";
$lang['um'] 							= "Unitate de masura";
$lang['image_file_tip'] 				= "Max. 300 KB si 600x600";
$lang['pr_code_tip'] 					= "Codul produsului trebuie sa fie Unic.";
$lang['pr_name_tip'] 					= "Nume produs";
$lang['pr_unit_tip'] 					= "Cod produs pentru referinta";
$lang['pr_size_tip'] 					= "Marime produs pentru referinta";
$lang['pr_um_tip'] 						= "U.M Produs pentru facturi";
$lang['unit_price_tip'] 				= "This Price will be auto populated in Invoice for this product.";
$lang['product_cost_tip'] 				= "Pret de cost (Fara TVA). Acest pret va fi actualizat atunci cand se introduce o noua intrare.";
$lang['product_price_tip'] 				= "Pret de vanzare (Fara TVA). Pretul final va fi populat automat in Factura.";
$lang['alert_quantity_tip'] 			= "Va rugam sa introduceti Alerta de Cantitate pentru acest produs.";
$lang['all_warehouses'] 				= "Toate Gestiunile";
$lang['image'] 							= "Imagine";
$lang['edit_product'] 					= "Modifica Produs";
$lang['delete_product'] 				= "Sterge Produs";
$lang['alert_x_product'] 				= "Aveti de gand sa stergeti acest produs?. Apasati OK pentru a continua si Cancel pentru a va intoarce.";
$lang['quantity'] 						= "Cantitate";
$lang['change_photo'] 					= "Schimba Imagine";
$lang['add_products'] 					= "Adauga Produse";
$lang['view_transfer'] 					= "Vizuazilare Transfer";
$lang['add_transfer'] 					= "Adauga Transfer";
$lang['transfer_product'] 				= "Transfera Produse";


$lang['sales'] 							= "Vanzari";
$lang['total_sales'] 					= "Total Vanzari";
$lang['invoice'] 						= "Factura";
$lang['invoice_type'] 					= "Tip Factura";
$lang['tax_rate'] 						= "Taxe";
$lang['reference_no'] 					= "Nr. Referinta";
$lang['sale_added'] 					= "Vanzarea a fost adaugata cu succes";
$lang['add_sale']						= "Adauga Vanzare Noua";
$lang['sale_updated'] 					= "Vanzarea a fost actualizata cu succes";
$lang['update_sale'] 					= "Actualizare Vanzare";
$lang['billed_to'] 						= "Facturat catre";
$lang['tax'] 							= "Taxe";
$lang['tax_value'] 						= "Valoare Taxa";
$lang['buyer'] 							= "Cumparator";
$lang['signature'] 						= "Semnatura";
$lang['total_no_tax'] 					= "Total (Fara TVA)";
$lang['biller'] 						= "Vanzator";
$lang['stamp'] 							= "Stampila";
$lang['customer'] 						= "Client";
$lang['total'] 							= "Total";
$lang['view_invoice'] 					= "Vizualizare Factura";
$lang['email_invoice'] 					= "Trimite Factura prin E-mail";
$lang['edit_invoice'] 					= "Modifica Factura";
$lang['chart_heading'] 					= "Va rugam sa revizuiti vânzarile totale pentru fiecare luna! Aveti posibilitatea sa salvati Graficul in format jpg, png si pdf.";
$lang['product_reports'] 				= "Raport Produse";
$lang['purchase_reports'] 				= "Raport Intrari";
$lang['sale_reports'] 					= "Raport Vanzari";
$lang['all_products'] 					= "Toate Produsele";
$lang['product_alerts'] 				= "Alerta Produse";
$lang['report_type'] 					= "Tip Raport";
$lang['get_report'] 					= "Cere Raport";
$lang['stock_balance'] 					= "Balanta de stoc";
$lang['no_report'] 						= "Nimic pentru a afisa! Va rugam sa încercati din nou cu alta interogare";
$lang['start_date'] 					= "Din Data";
$lang['end_date'] 						= "Catre Data";


$lang['site_name'] 						= "Nume Site";
$lang['language'] 						= "Limba";
$lang['default_warehouse'] 				= "Gestiunea Principala";
$lang['currency_code'] 					= "Moneda";
$lang['default_invoice_type'] 			= "Tip Factura Principala";
$lang['default_tax_rate'] 				= "Valoare Taxa Defaul";
$lang['rows_per_page'] 					= "Randuri per pagina";
$lang['total_rows'] 					= "Total Randuri";
$lang['setting_updated'] 				= "Setarile au fost actualizate cu succes";
$lang['update_settings'] 				= "Actualizare Setari";
$lang['site_name_tip'] 					= "Aceasta va fi folosita in Titlu &amp; footer.";
$lang['language_tip'] 					= "Selecteaza limba sistemului.";
$lang['default_warehouse_tip'] 			= "Gestiunea Principala. Toate intrarile vor fi varsate in aceasta gestiune.";
$lang['currency_code_tip'] 				= "Pentru facturi / Inventare.";
$lang['default_invoice_type_tip'] 		= "Factura tip Principala.";
$lang['default_tax_rate_tip'] 			= "Valoare Taxa Principala.";
$lang['total_rows_tip'] 				= "Nr. Total de randuri ce poate fi adaugat in Factura / Inventare.";
$lang['rows_per_page_tip'] 				= "Nr. Total de randuri ce poate fi vizualizat in Produse / Vanzari / Intrari.";
$lang['title'] 							= "Titlu";
$lang['rate'] 							= "Valoare";
$lang['type'] 							= "Tip";
$lang['tax_rate_added'] 				= "Valoare Taxa TVA a fost adaugat cu succes";
$lang['new_tax_rate'] 					= "Adauga Valoare noua de TVA";
$lang['tax_rate_updated'] 				= "Valoarea taxei a fost actualizata cu succes";
$lang['update_tax_rate'] 				= "Actualizare Valoarea taxei";
$lang['invoice_type_added'] 			= "Tip factura adaugat cu succes";
$lang['new_invoice_type'] 				= "Adauga nou tip Factura";
$lang['invoice_type_updated'] 			= "Tip factura actualizat cu succes";
$lang['update_invoice_type'] 			= "Actualizare tip Factura";
$lang['not_uploaded'] 					= "Problema cu Upload! Va rugam sa incercati mai tarziu sau sa contactati personalul de suport.";
$lang['logo_changed'] 					= "Logo Site a fost schimbat cu succes!";
$lang['change_logo'] 					= "Schimba Logo Site";
$lang['biller_logo_uploaded'] 			= "Logo Vanzator a fost actualizat cu succes!";
$lang['upload_biller_logo'] 			= "Incarca Logo pentru Vanzator";
$lang['warehouse_code'] 				= "Cod Gestiune";
$lang['warehouse_name']					= "Nume Gestiune";
$lang['warehouse_added'] 				= "Gestiunea adaugata cu succes!";
$lang['new_warehouse'] 					= "Adauga Gestiune";
$lang['warehouse_updated'] 				= "Gestiunea a fost actualizata cu succes!";
$lang['update_warehouse'] 				= "Actualizare Gestiune";
$lang['invoice_title_tip'] 				= "Va rugam sa ii dati un nume pentru tipul de factura.";
$lang['invoice_type_tip'] 				= "Va rugam selectati tipul. <strong>Real</strong> va reduce cantitatea produsului din stoc, dar <strong>Draft</strong> no.";
$lang['tax_rate_title_tip'] 			= "Va rugam sa ii dati un nume pentru Valoarea taxei.";
$lang['tax_rate_rate_tip'] 				= "Va rugam sa scrieti un tip de taxa si sa selectati <strong>%</strong> pentru procent &amp; <strong>$</strong> pentru suma fixa.";
$lang['warehouse_code_tip'] 			= "Va rugam sa introduceti un cod pentru gestiune.";
$lang['warehouse_name_tip'] 			= "Va rugam sa introduceti un nume pentru gestiune.";
$lang['warehouse_address_tip'] 			= "Va rugam sa introduceti informatiile privind localizarea gestiunii.";
$lang['warehouse_city_tip'] 			= "Va rugam sa introduceti un oras privind localizarea gestiunii.";
$lang['new_logo'] 						= "Logo Nou";
$lang['new_logo_tip'] 					= "Max. fisier 300 KB si (width=250px) x (height=80px).";
$lang['upload_logo'] 					= "Incarca Logo";
$lang['biller_logo'] 					= "Logo Vanzator";
$lang['biller_logo_tip'] 				= "Max. fisier 300 KB si (width=250px) x (height=80px).";
$lang['cf'] 							= "Custome Field";
$lang['help'] 							= "Ajutor";
$lang['documentation'] 					= "Documentation";
$lang['first'] 							= "Primul";
$lang['last'] 							= "Ultimul";
$lang['next'] 							= "Inainte";
$lang['previous'] 						= "Inapoi";

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Contul a fost creat cu succes';
$lang['account_creation_unsuccessful'] 	 	 = 'Nu se poate crea contul';
$lang['account_creation_duplicate_email'] 	 = 'Emailul deja exista in sistem sau nu este valid';
$lang['account_creation_duplicate_username'] = 'Utilizatorul deja exista in sistem sau nu este valid';

// Password
$lang['password_change_successful'] 	 	 = 'Parola a fost schimbata cu succes';
$lang['password_change_unsuccessful'] 	  	 = 'Nu se poate schimba parola';
$lang['forgot_password_successful'] 	 	 = 'Parola resetata a fost trimisa prin E-mail';
$lang['forgot_password_unsuccessful'] 	 	 = 'Nu se poate reseta parola';

// Activation
$lang['activate_successful'] 		  	     = 'Cont Activat';
$lang['activate_unsuccessful'] 		 	     = 'Nu se paote activa contul';
$lang['deactivate_successful'] 		  	     = 'Cont Dezactivat';
$lang['deactivate_unsuccessful'] 	  	     = 'Nu se poate dezactiva contul';
$lang['activation_email_successful'] 	  	 = 'E-mail de activare cont trimis';
$lang['activation_email_unsuccessful']   	 = 'Nu se poate trimite email de activare cont';

// Login / Logout
$lang['login_successful'] 		  	         = 'Autentificat cu succes';
$lang['login_unsuccessful'] 		  	     = 'Autentificare gresita!';
$lang['login_unsuccessful_not_active'] 		 = 'Contul inactiv';
$lang['logout_successful'] 		 	         = 'Logged Out Successfully';

// Account Changes
$lang['update_successful'] 		 	         = 'Informatii cont actualizat cu succes';
$lang['update_unsuccessful'] 		 	     = 'Nu se poate actualiza informatiile de cont';
$lang['delete_successful'] 		 	         = 'Utilizator sters';
$lang['delete_unsuccessful'] 		 	     = 'Nu se paote sterge acest utilizator';

// Email Subjects
$lang['email_forgotten_password_subject']    = 'Am uitat parola de autentificare';
$lang['email_new_password_subject']          = 'Parola Noua';
$lang['email_activation_subject']            = 'Activare cont';


$lang['alert_x_biller'] = "Aveti de gand sa stergeti acest vanzator?. Apasati OK pentru a continua si Cancel pentru a va intoarce";
$lang['alert_x_customer'] = "Aveti de gand sa stergeti acest client?. Apasati OK pentru a continua si Cancel pentru a va intoarce";
$lang['alert_x_supplier'] = "Aveti de gand sa stergeti acest furnizor?. Apasati OK pentru a continua si Cancel pentru a va intoarce";
$lang['alert_x_user'] = "Aveti de gand sa stergeti acest utilizator?. Apasati OK pentru a continua si Cancel pentru a va intoarce";
$lang['alert_x_product'] = "Aveti de gand sa stergeti acest produs?. Apasati OK pentru a continua si Cancel pentru a va intoarce";


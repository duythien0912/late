#!/bin/fish

# grep -rli '\'Search\'' * | xargs -I@ sed -i '' 's/\'Search\'/\'Ricerca\'/g' @
# ; grep -rli '\'No Appointments Found\'' * | xargs -I@ sed -i '' 's/\'No Appointments Found\'/\'Non ci sono Appuntamenti\'/g' @
# ; grep -rli '\'Create Appointment\'' * | xargs -I@ sed -i '' 's/\'Create Appointment\'/\'Crea un appuntamento\'/g' @
# ; grep -rli '\'Appointments Timeline\'' * | xargs -I@ sed -i '' 's/\'Appointments Timeline\'/\'Timeline degli Appuntamenti\'/g' @
# ; grep -rli '\'No Agents Created\'' * | xargs -I@ sed -i '' 's/\'No Agents Created\'/\'Nessun Personale Selezionato \'/g' @
# ; grep -rli '\'Create Agents\'' * | xargs -I@ sed -i '' 's/\'Create Agents\'/\'Aggiungi un nuovo membro al personale\'/g' @

# ; grep -rli '\'Performance\'' * | xargs -I@ sed -i '' 's/\'Performance\'/\'Le tue performance\'/g' @
# ; grep -rli '\'All Services\'' * | xargs -I@ sed -i '' 's/\'All Services\'/\'Tutti i Servizi\'/g' @
# ; grep -rli '\'All Agents\'' * | xargs -I@ sed -i '' 's/\'All Agents\'/\'Tutto il Personale\'/g' @
# ; grep -rli '\'New Appointment\'' * | xargs -I@ sed -i '' 's/\'New Appointment\'/\'Nuovo Appuntamento\'/g' @
# ; grep -rli '\'Daily View\'' * | xargs -I@ sed -i '' 's/\'Daily View\'/\'Appuntamenti del Giorno\'/g' @
# ; grep -rli '\'Monthly View\'' * | xargs -I@ sed -i '' 's/\'Monthly View\'/\'Appuntamenti del Mese\'/g' @
# ; grep -rli '\'Weekly View\'' * | xargs -I@ sed -i '' 's/\'Weekly View\'/\'Appuntamenti della Settimana\'/g' @

# ; grep -rli '\'All Appointments\'' * | xargs -I@ sed -i '' 's/\'All Appointments\'/\'Tutti gli Appuntamenti\'/g' @
# ; grep -rli '\'Pending Approval\'' * | xargs -I@ sed -i '' 's/\'Pending Approval\'/\'Da Approvare\'/g' @
# ; grep -rli '\'No Existing Appointments Found\'' * | xargs -I@ sed -i '' 's/\'No Existing Appointments Found\'/\'Non Ci sono Appuntamenti\'/g' @
# ; grep -rli '\'Add first Appointment\'' * | xargs -I@ sed -i '' 's/\'Add first Appointment\'/\'Aggiungi un Nuovo Appuntamento\'/g' @
# ; grep -rli '\'List of Services\'' * | xargs -I@ sed -i '' 's/\'List of Services\'/\'Lista dei Servizi\'/g' @
# ; grep -rli '\'Service Categories\'' * | xargs -I@ sed -i '' 's/\'Service Categories\'/\'Le Categorie dei Servizi\'/g' @

# ; grep -rli '\'Dashboard\'' * | xargs -I@ sed -i '' 's/\'Dashboard\'/\'Home\'/g' @
# ; grep -rli '\'Create New Service Category\'' * | xargs -I@ sed -i '' 's/\'Create New Service Category\'/\'Crea una nuova Categoria dei Servizi\'/g' @
# ; grep -rli '\'Category Name\'' * | xargs -I@ sed -i '' 's/\'Category Name\'/\'Nome della Categoria\'/g' @
# ; grep -rli '\'Short description\'' * | xargs -I@ sed -i '' 's/\'Short description\'/\'Una piccola bio di Te\'/g' @
# ; grep -rli '\'Category Image\'' * | xargs -I@ sed -i '' 's/\'Category Image\'/\'Carica una foto della Categoria\'/g' @
# ; grep -rli '\'Save Category\'' * | xargs -I@ sed -i '' 's/\'Save Category\'/\'Salva Categoria\'/g' @
# ; grep -rli '\'Cancel\'' * | xargs -I@ sed -i '' 's/\'Cancel\'/\'Annulla\'/g' @
# ; grep -rli '\'Agents\'' * | xargs -I@ sed -i '' 's/\'Agents\'/\'Personale Scolastico\'/g' @

# ; grep -rli '\'Add first Agent\'' * | xargs -I@ sed -i '' 's/\'Add first Agent\'/\'Aggiungi il primo Membro del Personale\'/g' @
# ; grep -rli '\'No Existing Customers Found\'' * | xargs -I@ sed -i '' 's/\'No Existing Customers Found\'/\'Non ci sono Utenti in Database\'/g' @
# ; grep -rli '\'Add Customer\'' * | xargs -I@ sed -i '' 's/\'Add Customer\'/\'Aggiungi Utente\'/g' @
# ; grep -rli '\'General Information\'' * | xargs -I@ sed -i '' 's/\'General Information\'/\'Informazioni Generali\'/g' @
# ; grep -rli '\'Set Avatar\'' * | xargs -I@ sed -i '' 's/\'Set Avatar\'/\'Seleziona il tuo Avatar\'/g' @
# ; grep -rli '\'First Name\'' * | xargs -I@ sed -i '' 's/\'First Name\'/\'Il tuo Nome\'/g' @
# ; grep -rli '\'Last Name\'' * | xargs -I@ sed -i '' 's/\'Last Name\'/\'Il tuo Cognome\'/g' @

# ; grep -rli '\'Email Address\'' * | xargs -I@ sed -i '' 's/\'Email Address\'/\'Il tuo Indirizzo Email\'/g' @
# ; grep -rli '\'Phone Number\'' * | xargs -I@ sed -i '' 's/\'Phone Number\'/\'Il tuo Numero di Telefono\'/g' @
# ; grep -rli '\'Notes by Costumer\'' * | xargs -I@ sed -i '' 's/\'Notes by Costumer\'/\'Note dell'utente\'/g' @
# ; grep -rli '\'Save Customer\'' * | xargs -I@ sed -i '' 's/\'Save Customer\'/\'Salva\'/g' @
# ; grep -rli '\'Locations\'' * | xargs -I@ sed -i '' 's/\'Locations\'/\'Le mie Sedi\'/g' @
# ; grep -rli '\'Main Location\'' * | xargs -I@ sed -i '' 's/\'Main Location\'/\'Le mie Sedi\'/g' @
# ; grep -rli '\'Edit \'' * | xargs -I@ sed -i '' 's/\'Edit \'/\'Modifica\'/g' @

# ; grep -rli '\'Add Location\'' * | xargs -I@ sed -i '' 's/\'Add Location\'/\'Aggiungi una Sede\'/g' @
# ; grep -rli '\'Agents\'' * | xargs -I@ sed -i '' 's/\'Agents\'/\'Personale Scolastico\'/g' @
# ; grep -rli '\'No Agents Assigned\'' * | xargs -I@ sed -i '' 's/\'No Agents Assigned\'/\'Non Assegnato a Nessuno\'/g' @
# ; grep -rli '\'General\'' * | xargs -I@ sed -i '' 's/\'General\'/\'Generale\'/g' @
# ; grep -rli '\'Appointment Settings\'' * | xargs -I@ sed -i '' 's/\'Appointment Settings\'/\'Impostazioni degli Appuntamenti\'/g' @
# ; grep -rli '\'Default Appointment Status\'' * | xargs -I@ sed -i '' 's/\'Default Appointment Status\'/\'Default degli Appuntamenti\'/g' @
# ; grep -rli '\'Time System\'' * | xargs -I@ sed -i '' 's/\'Time System\'/\'Orario\'/g' @
# ; grep -rli '\'Date Format\'' * | xargs -I@ sed -i '' 's/\'Date Format\'/\'Formato Data\'/g' @





# ; grep -rli '\'Selectable Time Intervals in Minutes\'' * | xargs -I@ sed -i '' 's/\'Selectable Time Intervals in Minutes\'/\'Seleziona Tempo di Intervallo in Minuti\'/g' @
# ; grep -rli '\'Restrictions\'' * | xargs -I@ sed -i '' 's/\'Restrictions\'/\'Restizioni\'/g' @
# ; grep -rli '\'Disable Verbose Date Output\'' * | xargs -I@ sed -i '' 's/\'Disable Verbose Date Output\'/\'Disabilita output di date dettagliate\'/g' @
# ; grep -rli '\'Other Settings\'' * | xargs -I@ sed -i '' 's/\'Other Settings\'/\'Altre Impostazioni\'/g' @
# ; grep -rli '\'Shortcode for a book button on customer dashboard\'' * | xargs -I@ sed -i '' 's/\'Shortcode for a book button on customer dashboard\'/\'Shortcode per un pulsante del Sistema di Appuntamenti AppoinTy\'/g' @
# ; grep -rli '\'Setup Pages\'' * | xargs -I@ sed -i '' 's/\'Setup Pages\'/\'Pagina di Configurazione\'/g' @
# ; grep -rli '\'Social Login\'' * | xargs -I@ sed -i '' 's/\'Social Login\'/\'Login con i Social \'/g' @



# ; grep -rli '\'Enable Login with Google\'' * | xargs -I@ sed -i '' 's/\'Enable Login with Google\'/\'Effettua Login con Google\'/g' @
# ; grep -rli '\'Enable Login with Facebook\'' * | xargs -I@ sed -i '' 's/\'Enable Login with Facebook\'/\'Effettua Login con Facebook\'/g' @
# ; grep -rli '\'Phone Settings\'' * | xargs -I@ sed -i '' 's/\'Phone Settings\'/\'Informazioni di Contatto Telefonico\'/g' @
# ; grep -rli '\'Phone Input Mask\'' * | xargs -I@ sed -i '' 's/\'Phone Input Mask\'/\'Maschera di input del telefono\'/g' @
# ; grep -rli '\'Disable Phone Formatting\'' * | xargs -I@ sed -i '' 's/\'Disable Phone Formatting\'/\'Disabilita input del Telefono\'/g' @
# ; grep -rli '\'Phone Input Mask\'' * | xargs -I@ sed -i '' 's/\'Phone Input Mask\'/\'Maschera input del Telefono\'/g' @
# ; grep -rli '\'Phone code for your country\'' * | xargs -I@ sed -i '' 's/\'Phone code for your country\'/\'Prefisso telefonico per il tuo paese\'/g' @
# ; grep -rli '\'Currency symbol in front of price\'' * | xargs -I@ sed -i '' 's/\'Currency symbol in front of price\'/\'--\'/g' @
# ; grep -rli '\'Agents can only be present in one location at a time\'' * | xargs -I@ sed -i '' 's/\'Agents can only be present in one location at a time\'/\'Il Personale Scolastico può essere presente solo in una posizione alla volta\'/g' @
# ; grep -rli '\'Earliest Possible Booking\'' * | xargs -I@ sed -i '' 's/\'Earliest Possible Booking\'/\'Prima prenotazione possibile\'/g' @
# ; grep -rli '\'Latest Possible Booking\'' * | xargs -I@ sed -i '' 's/\'Latest Possible Booking\'/\'Ultima prenotazione possibile\'/g' @
# ; grep -rli '\'Maximum Number of Future Bookings per Customer\'' * | xargs -I@ sed -i '' 's/\'Maximum Number of Future Bookings per Customer\'/\'Numero massimo di prenotazioni future per Utente\'/g' @
# ; grep -rli '\'Settings\'' * | xargs -I@ sed -i '' 's/\'Settings\'/\'Impostazioni\'/g' @



# ; grep -rli '\'Email Settings\'' * | xargs -I@ sed -i '' 's/\'Email Settings\'/\'Impostazioni delle Email\'/g' @
# ; grep -rli '\'Enable Email Notifications\'' * | xargs -I@ sed -i '' 's/\'Enable Email Notifications\'/\'Abilita Notifiche via Email\'/g' @
# ; grep -rli '\'Save Settings\'' * | xargs -I@ sed -i '' 's/\'Save Settings\'/\'Salva Impostazioni\'/g' @
# ; grep -rli '\'Email Templates\'' * | xargs -I@ sed -i '' 's/\'Email Templates\'/\'Template delle Email\'/g' @
# ; grep -rli '\'You can use these variables in your email and sms notifications. Just click on the variable with {} brackets and it will automatically copy to your buffer and you can simply paste it where you want to use it. It will be converted into a value for the agent/service or appointment.\'' * | xargs -I@ sed -i '' 's/\'You can use these variables in your email and sms notifications. Just click on the variable with {} brackets and it will automatically copy to your buffer and you can simply paste it where you want to use it. It will be converted into a value for the agent/service or appointment.\'/\'Puoi utilizzare queste variabili nelle notifiche e-mail e sms. Basta fare clic sulla variabile con parentesi {} e verrà automaticamente copiata nel buffer e puoi semplicemente incollarla dove vuoi usarla. Verrà convertito in un valore per l'agente / servizio o l'appuntamento.\'/g' @
# ; grep -rli '\'Appointment\'' * | xargs -I@ sed -i '' 's/\'Appointment\'/\'Appuntamenti\'/g' @
# ; grep -rli '\'Payment\'' * | xargs -I@ sed -i '' 's/\'Payment\'/\'Pagamenti\'/g' @
# ; grep -rli '\'Customer\'' * | xargs -I@ sed -i '' 's/\'Customer\'/\'Utente\'/g' @
# ; grep -rli '\'Agent\'' * | xargs -I@ sed -i '' 's/\'Agent\'/\'Personale Scolastico\'/g' @
# ; grep -rli '\'Location\'' * | xargs -I@ sed -i '' 's/\'Location\'/\'Sedi\'/g' @
# ; grep -rli '\'Agent Email Notifications\'' * | xargs -I@ sed -i '' 's/\'Agent Email Notifications\'/\'Email del Personale Scolastico\'/g' @
# ; grep -rli '\'Enable Appointment Confirmation Email to Agent\'' * | xargs -I@ sed -i '' 's/\'Enable Appointment Confirmation Email to Agent\'/\'Abilita email di Conferma Appuntamento con Personale Scolastico\'/g' @
# ; grep -rli '\'Enable Agent Notification of Appointment Status Change\'' * | xargs -I@ sed -i '' 's/\'Enable Agent Notification of Appointment Status Change\'/\'Abilita email di Cambiamento Status Appuntamento con Personale Scolastico\'/g' @
# ; grep -rli '\'Send email notification to agents about new messages\'' * | xargs -I@ sed -i '' 's/\'Send email notification to agents about new messages\'/\'Invia Email di notifica quando un membro del Personale Scolastico invia un nuovo messaggio\'/g' @
# ; grep -rli '\'Customer Email Notifications\'' * | xargs -I@ sed -i '' 's/\'Customer Email Notifications\'/\'Email degli Utenti\'/g' @
# ; grep -rli '\'Enable Appointment Confirmation Email to Customer\'' * | xargs -I@ sed -i '' 's/\'Enable Appointment Confirmation Email to Customer\'/\'Abilita email di Conferma Appuntamento con l'Utente\'/g' @
# ; grep -rli '\'Send email notification to customers about new messages\'' * | xargs -I@ sed -i '' 's/\'Send email notification to customers about new messages\'/\'Invia Email di notifica quando un Utente invia un nuovo messaggio\'/g' @
# ; grep -rli '\'Other Customer Emails\'' * | xargs -I@ sed -i '' 's/\'Other Customer Emails\'/\'Altre email dei clienti\'/g' @
# ; grep -rli '\'Customer Password Reset Request\'' * | xargs -I@ sed -i '' 's/\'Customer Password Reset Request\'/\'Richiesta di Reset della Password\'/g' @
# ; grep -rli '\'Email Subject\'' * | xargs -I@ sed -i '' 's/\'Email Subject\'/\'Oggetto della mail\'/g' @
# ; grep -rli '\'CUSTOM FIELDS\'' * | xargs -I@ sed -i '' 's/\' CUSTOM FIELDS\'/\'CUSTOM\'/g' @
# ; grep -rli '\'Fields For Customer\'' * | xargs -I@ sed -i '' 's/\'Fields For Customer\'/\'Campi per il cliente\'/g' @
# ; grep -rli '\'Add Custom Field\'' * | xargs -I@ sed -i '' 's/\'Add Custom Field\'/\'Aggiungi nuovo campo\'/g' @
# ; grep -rli '\'New Field\'' * | xargs -I@ sed -i '' 's/\'New Field\'/\'Nuovo Campo\'/g' @
# ; grep -rli '\'Field Label\'' * | xargs -I@ sed -i '' 's/\'Field Label\'/\'Etichetta di campo\'/g' @
# ; grep -rli '\'Field Type\'' * | xargs -I@ sed -i '' 's/\'Field Type\'/\'Tipo di campo\'/g' @
# ; grep -rli '\'Field Width\'' * | xargs -I@ sed -i '' 's/\'Field Width\'/\'Larghezza campo\'/g' @
# ; grep -rli '\'Field Visibility\'' * | xargs -I@ sed -i '' 's/\'Field Visibility\'/\'Visibilità sul campo\'/g' @
# ; grep -rli '\'Fields For Booking\'' * | xargs -I@ sed -i '' 's/\'Fields For Booking\'/\'Campi per la prenotazione\'/g' @
# ; grep -rli '\'BACK TO YOUR WEBSITE\'' * | xargs -I@ sed -i '' 's/\'BACK TO YOUR WEBSITE\'/\'TORNA AL SITO WEB\'/g' @
# ; grep -rli '\'New Appointment\'' * | xargs -I@ sed -i '' 's/\'New Appointment\'/\'Nuovo Appuntamento\'/g' @
# ; grep -rli '\'No Active Services Found.\'' * | xargs -I@ sed -i '' 's/\'No Active Services Found.\'/\'Nessun servizio attivo trovato.\'/g' @
# ; grep -rli '\'Agent\'' * | xargs -I@ sed -i '' 's/\'Agent\'/\'Personale Scolastico\'/g' @
# ; grep -rli '\'Set Status\'' * | xargs -I@ sed -i '' 's/\'Set Status\'/\'Seleziona Status\'/g' @
# ; grep -rli '\'Approved\'' * | xargs -I@ sed -i '' 's/\'Approved\'/\'Approvato\'/g' @
# ; grep -rli '\'Pending Approval\'' * | xargs -I@ sed -i '' 's/\'Pending Approval\'/\'Da Approvare\'/g' @
# ; grep -rli '\'Cancelled\'' * | xargs -I@ sed -i '' 's/\'Cancelled\'/\'Cancellato\'/g' @
# ; grep -rli '\'Start Date\'' * | xargs -I@ sed -i '' 's/\'Start Date\'/\'Data \'/g' @
# ; grep -rli '\'Show Calendar\'' * | xargs -I@ sed -i '' 's/\'Show Calendar\'/\'Mostra Calendario\'/g' @
# ; grep -rli '\'Start Time\'' * | xargs -I@ sed -i '' 's/\'Start Time\'/\'Orario di Inizio\'/g' @
# ; grep -rli '\'End Time\'' * | xargs -I@ sed -i '' 's/\'End Time\'/\'Orario di Fine\'/g' @
# ; grep -rli '\'Buffer Before\'' * | xargs -I@ sed -i '' 's/\'Buffer Before\'/\'Buffer Prima\'/g' @
# ; grep -rli '\'Buffer After\'' * | xargs -I@ sed -i '' 's/\'Buffer After\'/\'Buffer Dopo\'/g' @
# ; grep -rli '\'Customer\'' * | xargs -I@ sed -i '' 's/\'Customer\'/\'Utente\'/g' @
# ; grep -rli '\'First Name\'' * | xargs -I@ sed -i '' 's/\'First Name\'/\'Nome \'/g' @
# ; grep -rli '\'Last Name\'' * | xargs -I@ sed -i '' 's/\'Last Name\'/\'Cognome\'/g' @
# ; grep -rli '\'Email Address\'' * | xargs -I@ sed -i '' 's/\'Email Address\'/\'Indirizzo Email\'/g' @
# ; grep -rli '\'Telephone Number\'' * | xargs -I@ sed -i '' 's/\'Telephone Number\'/\'Numero di Telefono\'/g' @



grep -rli '\'No Upcoming Appointments\'' * | xargs -I@ sed -i '' 's/\'No Upcoming Appointments\'/\'Nessun appuntamento imminente\'/g' @
grep -rli '\'No Existing Agents Found\'' * | xargs -I@ sed -i '' 's/\'No Existing Agents Found\'/\'Nessun membro scolastico trovato\'/g' @
grep -rli '\'Add First Agent\'' * | xargs -I@ sed -i '' 's/\'Add First Agent\'/\'Aggiungi il primo membro scolastico\'/g' @
grep -rli '\'Add First Appointment\'' * | xargs -I@ sed -i '' 's/\'Add First Appointment\'/\'Aggiungi il primo appuntamento\'/g' @
grep -rli '\'All\'' * | xargs -I@ sed -i '' 's/\'All\'/\'Tutti\'/g' @
grep -rli '\'No Pending Appointments Found\'' * | xargs -I@ sed -i '' 's/\'No Pending Appointments Found\'/\'Nessun appuntamento in sospeso trovato\'/g' @
grep -rli '\'No Services Found\'' * | xargs -I@ sed -i '' 's/\'No Services Found\'/\'Non ci sono servizi\'/g' @
grep -rli '\' Add Service\'' * | xargs -I@ sed -i '' 's/\' Add Service\'/\'Aggiungi Servizi\'/g' @
grep -rli '\'Create New Category\'' * | xargs -I@ sed -i '' 's/\'Create New Category\'/\'Crea una nuova categoria\'/g' @
grep -rli '\'No Existing Agents Found\'' * | xargs -I@ sed -i '' 's/\'No Existing Agents Found\'/\'Non c'è nessuno nel personale scolastico\'/g' @
grep -rli '\'Add First Agent\'' * | xargs -I@ sed -i '' 's/\'Add First Agent\'/\'Aggiungi membro\'/g' @
grep -rli '\'Create New Agent\'' * | xargs -I@ sed -i '' 's/\'Create New Agent\'/\'Crea un nuovo membro\'/g' @
grep -rli '\'Connect to WP User\'' * | xargs -I@ sed -i '' 's/\'Connect to WP User\'/\'Collega ad un utente Wordpress\'/g' @
grep -rli '\'Additional Contact Information\'' * | xargs -I@ sed -i '' 's/\'Additional Contact Information\'/\'Info contatto supplementare\'/g' @
grep -rli '\'Additional Email Addresses\'' * | xargs -I@ sed -i '' 's/\'Additional Email Addresses\'/\'Email supplementare\'/g' @
grep -rli '\'Additional Phone Numbers\'' * | xargs -I@ sed -i '' 's/\'Additional Phone Numbers\'/\'Numero supplementare\'/g' @
grep -rli '\'If you need to notify multiple persons about the appointment, you can list additional email addresses and phone numbers to send notification emails and sms to. You can list multiple numbers and emails separated by commas.\'' * | xargs -I@ sed -i '' 's/\'If you need to notify multiple persons about the appointment, you can list additional email addresses and phone numbers to send notification emails and sms to. You can list multiple numbers and emails separated by commas.\'/\'Se è necessario avvisare più persone dell'appuntamento, è possibile elencare indirizzi e-mail e numeri di telefono aggiuntivi a cui inviare e-mail e sms di notifica. Puoi elencare più numeri ed e-mail separati da virgole.\'/g' @
grep -rli '\'Extra Information\'' * | xargs -I@ sed -i '' 's/\'Extra Information\'/\'Informazioni extra\'/g' @
grep -rli '\'Offered Services\'' * | xargs -I@ sed -i '' 's/\'Offered Services\'/\'Servizi Offerti\'/g' @
grep -rli '\'Add Agent\'' * | xargs -I@ sed -i '' 's/\'Add Agent\'/\'Aggiungi Personale Scolastico\'/g' @
grep -rli '\'Create New Location\'' * | xargs -I@ sed -i '' 's/\'Create New Location\'/\'Crea una nuova sede\'/g' @
grep -rli '\'Basic Information\'' * | xargs -I@ sed -i '' 's/\'Basic Information\'/\'Informazioni \'/g' @
grep -rli '\'Location Name\'' * | xargs -I@ sed -i '' 's/\'Location Name\'/\'Nome\'/g' @
grep -rli '\'Location Address\'' * | xargs -I@ sed -i '' 's/\'Location Address\'/\'Indirizzo\'/g' @
grep -rli '\'Select Agents for This Location\'' * | xargs -I@ sed -i '' 's/\'Select Agents for This Location\'/\'Seleziona personale scolastico in questa sede\'/g' @
grep -rli '\'Location Schedule\'' * | xargs -I@ sed -i '' 's/\'Location Schedule\'/\'Pianificazione della posizione\'/g' @
grep -rli '\'Save Location\'' * | xargs -I@ sed -i '' 's/\'Save Location\'/\'Salva\'/g' @
grep -rli '\'Set Custom Schedule\'' * | xargs -I@ sed -i '' 's/\'Set Custom Schedule\'/\'Imposta pianificazione personalizzata\'/g' @
grep -rli '\'General Weekly Schedule\'' * | xargs -I@ sed -i '' 's/\'General Weekly Schedule\'/\'Programma settimanale generale\'/g' @
grep -rli '\'Add another work period for Monday\'' * | xargs -I@ sed -i '' 's/\'Add another work period for Monday\'/\'Seleziona una posizione in cui desideri che venga eseguito il servizio\'/g' @
grep -rli '\'Save Weekly Schedule\'' * | xargs -I@ sed -i '' 's/\'Save Weekly Schedule\'/\'Salva\'/g' @
grep -rli '\'Days With Custom Schedules\'' * | xargs -I@ sed -i '' 's/\'Days With Custom Schedules\'/\'Giorni con orari \'/g' @
grep -rli '\'Holidays & Days Off\'' * | xargs -I@ sed -i '' 's/\'Holidays & Days Off\'/\'Giorni di permesso o feriali\'/g' @
grep -rli '\'Pick a Date\'' * | xargs -I@ sed -i '' 's/\'Pick a Date\'/\'Scegli una data\'/g' @
grep -rli '\'Work Schedule Settings\'' * | xargs -I@ sed -i '' 's/\'Work Schedule Settings\'/\'Impostazioni del programma di lavoro\'/g' @
grep -rli '\'Add Day\'' * | xargs -I@ sed -i '' 's/\'Add Day\'/\'Aggiungi giorno\'/g' @
grep -rli '\'Monday\'' * | xargs -I@ sed -i '' 's/\'Monday\'/\'lunedì\'/g' @
;grep -rli '\'Tuesday\'' * | xargs -I@ sed -i '' 's/\'Tuesday\'/\'martedí\'/g' @
;grep -rli '\'Wednesday\'' * | xargs -I@ sed -i '' 's/\'Wednesday\'/\'mercoledì\'/g' @
;grep -rli '\'Thursday\'' * | xargs -I@ sed -i '' 's/\'Thursday\'/\'giovedì\'/g' @
;grep -rli '\'Friday\'' * | xargs -I@ sed -i '' 's/\'Friday\'/\'venerdì\'/g' @
;grep -rli '\'Saturday\'' * | xargs -I@ sed -i '' 's/\'Saturday\'/\'sabato\'/g' @
;grep -rli '\'Sunday\'' * | xargs -I@ sed -i '' 's/\'Sunday\'/\'domenica\'/g' @
;grep -rli '\'Step Editing\'' * | xargs -I@ sed -i '' 's/\'Step Editing\'/\'Modifica dei passaggi\'/g' @
grep -rli '\'Select Location\'' * | xargs -I@ sed -i '' 's/\'Select Location\'/\'Seleziona la località\'/g' @
grep -rli '\'Save Step\'' * | xargs -I@ sed -i '' 's/\'Save Step\'/\'Salva\'/g' @
grep -rli '\'Please select a location you want the service to be performed at\'' * | xargs -I@ sed -i '' 's/\'Please select a location you want the service to be performed at\'/\'Seleziona una posizione in cui desideri che venga eseguito il servizio\'/g' @
grep -rli '\'Save Settings\'' * | xargs -I@ sed -i '' 's/\'Save Settings\'/\'Salva \'/g' @
grep -rli '\'Calendar Settings\'' * | xargs -I@ sed -i '' 's/\'Calendar Settings\'/\'Settaggi Calendario\'/g' @
grep -rli '\'Enable Google Calendar Integration\'' * | xargs -I@ sed -i '' 's/\'Enable Google Calendar Integration\'/\'Abilita Google Calendar\'/g' @
grep -rli '\'back to your website\'' * | xargs -I@ sed -i '' 's/\'back to your website\'/\'Torna al sito web\'/g' @
grep -rli '\'Create Agent\'' * | xargs -I@ sed -i '' 's/\'Create Agent\'/\'Aggiungi un nuovo membro al personale\'/g' @
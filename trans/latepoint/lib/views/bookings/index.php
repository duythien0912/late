<?php if($bookings){ ?>
  <div class="table-with-pagination-w">
    <div class="os-bookings-list">
      <div class="os-table-w os-table-compact">
        <table class="os-table" data-route="<?php echo OsRouterHelper::build_route_name('bookings', 'index'); ?>">
          <thead>
            <tr>
              <th><?php _e('ID', 'latepoint'); ?></th>
              <th><?php _e('Service', 'latepoint'); ?></th>
              <th><?php _e('Date', 'latepoint'); ?></th>
              <th><?php _e('Time', 'latepoint'); ?></th>
              <?php if(!$show_single_agent){ ?><th><?php _e('Personale Scolastico', 'latepoint'); ?></th><?php } ?>
              <th><?php _e('Utente', 'latepoint'); ?></th>
              <th><?php _e('Status', 'latepoint'); ?></th>
              <th><?php _e('Created On', 'latepoint'); ?></th>
              <th><?php _e('Actions', 'latepoint'); ?></th>
            </tr>
            <tr>
              <th><?php echo OsFormHelper::text_field('filter[id]', __('ID', 'latepoint'), '', ['style' => 'width: 40px;', 'class' => 'os-table-filter']); ?></th>
              <th><?php echo OsFormHelper::select_field('filter[service_id]', false, OsServiceHelper::get_services_list(), '', ['placeholder' => __('Tutti i Servizi', 'latepoint'), 'class' => 'os-table-filter']); ?></th>
              <th colspan="2">
                <div class="os-form-group">
                  <div class="os-date-range-picker os-table-filter-datepicker" data-can-be-cleared="yes" data-no-value-label="<?php _e('Search by Appointment Date', 'latepoint'); ?>" data-clear-btn-label="<?php _e('Reset Date Search', 'latepoint'); ?>">
                    <span class="range-picker-value"><?php _e('Search by Appointment Date', 'latepoint'); ?></span>
                    <i class="latepoint-icon latepoint-icon-chevron-down"></i>
                    <input type="hidden" class="os-table-filter os-datepicker-date-from" name="filter[booking_date_from]" value=""/>
                    <input type="hidden" class="os-table-filter os-datepicker-date-to" name="filter[booking_date_to]" value=""/>
                  </div>
                </div>
              </th>
              <?php if(!$show_single_agent){ ?>
                <th><?php echo OsFormHelper::select_field('filter[agent_id]', false, OsAgentHelper::get_agents_list(), '', ['placeholder' => __('Tutto il Personale', 'latepoint'), 'class' => 'os-table-filter']); ?></th>
              <?php } ?>
              <th><?php echo OsFormHelper::text_field('filter[customer]', __('Search by Customer', 'latepoint'), '', ['class' => 'os-table-filter']); ?></th>
              <th><?php echo OsFormHelper::select_field('filter[status]', false, OsBookingHelper::get_statuses_list(), '', ['placeholder' => __('All Statuses', 'latepoint'), 'class' => 'os-table-filter']); ?></th>
              <th>
                <div class="os-form-group">
                  <div class="os-date-range-picker os-table-filter-datepicker" data-single-date="yes" data-can-be-cleared="yes" data-no-value-label="<?php _e('Filter Date', 'latepoint'); ?>" data-clear-btn-label="<?php _e('Reset Date Search', 'latepoint'); ?>">
                    <span class="range-picker-value"><?php _e('Filter Date', 'latepoint'); ?></span>
                    <i class="latepoint-icon latepoint-icon-chevron-down"></i>
                    <input type="hidden" class="os-table-filter os-datepicker-date-from" name="filter[created_date_from]" value=""/>
                    <input type="hidden" class="os-table-filter os-datepicker-date-to" name="filter[created_date_to]" value=""/>
                  </div>
                </div>
              </th>
              <th>
                  <div style="display: flex; flex-direction: column;">
                      <a style="margin-bottom: 4px" href="<?php echo OsRouterHelper::build_admin_post_link(OsRouterHelper::build_route_name('bookings', 'index') ) ?>" target="_blank" class="latepoint-btn latepoint-btn-primary download-csv-with-filters"><i class="latepoint-icon latepoint-icon-download"></i><span><?php _e('Download .csv', 'latepoint'); ?></span></a>
                      <a style="background-color: #1C878E;" onclick="onClickExportPdf()" href="#pdf" class="latepoint-btn latepoint-btn-primary download-csv-with-filters"><i class="latepoint-icon latepoint-icon-download"></i><span><?php _e('Download .pdf', 'latepoint'); ?></span></a>
                  </div>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php include('_table_body.php'); ?>
          </tbody>
          <tfoot>
            <tr>
              <th><?php _e('ID', 'latepoint'); ?></th>
              <th><?php _e('Service', 'latepoint'); ?></th>
              <th><?php _e('Date', 'latepoint'); ?></th>
              <th><?php _e('Time', 'latepoint'); ?></th>
              <?php if(!$show_single_agent){ ?><th><?php _e('Personale Scolastico', 'latepoint'); ?></th><?php } ?>
              <th><?php _e('Utente', 'latepoint'); ?></th>
              <th><?php _e('Status', 'latepoint'); ?></th>
              <th><?php _e('Created On', 'latepoint'); ?></th>
              <th><?php _e('Actions', 'latepoint'); ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div class="os-pagination-w">
      <div class="pagination-info"><?php echo __('Showing bookings', 'latepoint'). ' <span class="os-pagination-from">'. $showing_from . '</span> '.__('to', 'latepoint').' <span class="os-pagination-to">'. $showing_to .'</span> '.__('of', 'latepoint').' <span class="os-pagination-total">'. $total_bookings. '</span>'; ?></div>
      <div class="pagination-page-select-w">
        <label for=""><?php _e('Page:', 'latepoint'); ?></label>
        <select name="page" class="pagination-page-select">
          <?php 
          for($i = 1; $i <= $total_pages; $i++){
            $selected = ($current_page_number == $i) ? 'selected' : '';
            echo '<option '.$selected.'>'.$i.'</option>';
          } ?>
        </select>
      </div>
    </div>
  </div>
  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>




<script>

    function printDiv(body, title) {
        let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

        mywindow.document.write(`<html><head>
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<style>
body {
    font-family: 'Poppins';font-size: 22px;
}
#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: center;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    color: orange;
    border: none;
}
</style>
  `);
        mywindow.document.write('</head><body >');
        mywindow.document.write(body);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        // mywindow.close();

        return true;
    }

    function onClickExportPdf() {
        console.log("onClickExportPdf");
        var doc = new jsPDF();

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = dd + '/' + mm + '/' + yyyy;

// var bodyHtml = "<table>";

        var bodyHtml = `
        <div style=" display: flex; flex-direction: column; align-items: center; "> 
            <span style="margin-top: 4px; font-size: 32px;color: #1C878E;font-family: ;text-align: center;width: 100%;font-weight: bold;" poppins';'="">
            Date ${today}
            </span>
        </div>
        `;

bodyHtml += `<table id="customers" style="width: 100%;border-collapse: collapse;width: 100%;    margin-top: 12px;">
<tbody style="
">
<tr>
<th>N⁰</th>
<th>Categoria</th>
<th>Nome cognome</th>
<th>Orario</th>
</tr>
        `; 

        jQuery(".ch-day-booking-i").each(function (index) {
            bodyHtml += "<tr>";
            bodyHtml += `<td>${index+1}</td>`;
            // bodyHtml += `<td>${jQuery(this).attr("data-id")}</td>`;
            bodyHtml += `<td>${jQuery(this).attr("data-service-name")}</td>`;
            bodyHtml += `<td>${jQuery(this).attr("data-agent-fullname")}</td>`;
            bodyHtml += `<td>${jQuery(this).attr("data-service-time")}</td>`;
            bodyHtml += "</tr>";


            // bodyHtml += "<span style='color: #1C878E;font-family: 'Poppins';font-size: 22px;'>#" + jQuery(this).attr("data-id") + " </span>"
            // bodyHtml += "- <span style='font-family: 'Poppins';font-size: 22px;'> " + jQuery(this).attr("data-service-name") + " </span>"
            // bodyHtml += "- <span style='font-family: 'Poppins';font-size: 22px;'> " + jQuery(this).attr("data-agent-fullname") + " </span>"
            // bodyHtml += "- <span style='font-family: 'Poppins';font-size: 22px;'> " + jQuery(this).attr("data-service-time") + " </span>"
            // bodyHtml += "<br/>"
        });
            // bodyHtml += "</table>"
            bodyHtml += `</tbody></table>`;

          printDiv(bodyHtml);
        
//         var body = `<html><head><title>All-Appointments-${today}.pdf</title>
// <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
// <style>
// body {
//     font-family: 'Poppins';font-size: 22px;
// }
// </style>
// <body>${bodyHtml}</body>
//   `;

//         doc.fromHTML(body, 15, 15, {
//             'width': 900,
//         });
        
        
        
//         // doc.save(`All-Appointments-${today}.pdf`);
// doc.output("dataurlnewwindow");


    }

</script>

<?php }else{ ?>
  <div class="no-results-w">
    <div class="icon-w"><i class="latepoint-icon latepoint-icon-book"></i></div>
    <h2><?php _e('Non Ci sono Appuntamenti', 'latepoint'); ?></h2>
    <a href="#" <?php echo OsBookingHelper::quick_booking_btn_html(); ?> class="latepoint-btn"><i class="latepoint-icon latepoint-icon-plus"></i><span><?php _e('Aggiungi il primo appuntamento', 'latepoint'); ?></span></a>
  </div>
<?php } ?>

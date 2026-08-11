document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: {
            url: 'http://localhost/projeto_fisio_api/Versao2/projeto_fisio_api/fullcalendar-com-bootstrap5/listar_evento.php', // URL do endpoint
            method: 'GET',
            failure: function () {
                alert('Erro ao carregar eventos!');
            }
        },
        editable: true,
        selectable: true
    });

    calendar.render();
});
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    if (!calendarEl) {
        console.error('Elemento #calendar não encontrado!');
        return;
    }

   var calendar = new FullCalendar.Calendar(calendarEl, {

    initialView: 'timeGridWeek',
    locale: 'pt-br',
    weekends: false,
    slotMinTime: "13:10:00",
    slotMaxTime: "16:30:00",

    slotDuration: "01:00:00",
    snapDuration: "01:00:00",

    defaultTimedEventDuration: "01:00:00",
    forceEventDuration: true,

    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'timeGridWeek,timeGridDay'
    },

    businessHours: [
    {
        daysOfWeek: [1,2,3,4,5],
        startTime: '13:10',
        endTime: '15:10'
    },
    {
        daysOfWeek: [1,2,3,4,5],
        startTime: '15:30',
        endTime: '16:30'
    }
    ],

    events: [
    {
        title: "Intervalo",
        startTime: "15:10",
        endTime: "15:30",
        daysOfWeek: [1,2,3,4,5],
        display: "background",
        color: "#ffb3b3"
    },
    {
        url: 'http://localhost/FISIO/projeto_fisio_api/fullcalendar-com-bootstrap5/listar_evento.php',
        method: 'GET'
    }
    ],

    editable: true,
    selectConstraint: "businessHours",
    selectable: true,

    eventClick: function (info) {
        if (info.event.id) {
            window.location.href = `../editar_agendamento.php?id=${info.event.id}`;
        }
    }

    });

    calendar.render();
});
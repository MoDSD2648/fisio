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
        allDaySlot: false,
        slotMinTime: "13:10:00",
        slotMaxTime: "17:30:00",
        slotDuration: "00:20:00",
        snapDuration: "00:10:00",
        defaultTimedEventDuration: "01:00:00",
        forceEventDuration: true,
        height: 'auto',
        expandRows: true,
        nowIndicator: true,

        slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridWeek,timeGridDay'
        },

        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia'
        },

        businessHours: [
            {
                daysOfWeek: [1, 2, 3, 4, 5],
                startTime: '13:10',
                endTime: '15:10'
            },
            {
                daysOfWeek: [1, 2, 3, 4, 5],
                startTime: '15:30',
                endTime: '17:30'
            }
        ],

        events: [
            {
                title: "Intervalo",
                startTime: "15:10",
                endTime: "15:30",
                daysOfWeek: [1, 2, 3, 4, 5],
                display: "background",
                color: "#ffcdd2"
            },
            {
                url: '../fullcalendar-com-bootstrap5/listar_evento.php',
                method: 'GET',
                failure: function () {
                    console.warn('Não foi possível carregar os eventos da agenda ou a tabela está vazia.');
                }
            }
        ],

        editable: false,
        selectable: true,
        selectConstraint: "businessHours",

        select: function (info) {
            var data = info.startStr.substring(0, 10);
            var hora = info.startStr.substring(11, 16);
            window.location.href = 'agendar.php?data=' + data + '&hora=' + hora;
        },

        eventClick: function (info) {
            if (info.event.id) {
                window.location.href = 'editar_agendamento.php?id=' + encodeURIComponent(info.event.id);
            }
        },

        eventDidMount: function (info) {
            console.log("Evento:", info.event.title);
            if (info.event.title && info.el) {
                var tooltip = info.event.title;
                if (info.event.extendedProps && info.event.extendedProps.status) {
                    tooltip += " (" + info.event.extendedProps.status + ")";
                }
                info.el.setAttribute('title', tooltip);
            }
        }
    });

    calendar.render();
});

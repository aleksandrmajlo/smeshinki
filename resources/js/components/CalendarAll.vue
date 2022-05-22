<template>
    <div class="row wrapCalendarAll">
        <loading :active.sync="isLoading" :is-full-page="fullPage"/>
        <div class="col-lg-12">

            <div class="text-center section">
                <date-picker
                    locale="uk"
                    v-model="date"
                    @dayclick="onDayClick"
                    :masks="masks"
                    :attributes="attrs"
                    is-expanded
                />

            </div>

        </div>
    </div>
</template>

<script>
    import DatePicker from "v-calendar/lib/components/date-picker.umd";
    import Loading from "vue-loading-overlay";
    import "vue-loading-overlay/dist/vue-loading.css";
    export default {
        name: "CalendarAll",
        data() {
            return {
                typecalendar:'',// тип календаря
                datatypes:[],
                date: "",
                attrs: [],
                masks: {
                    input: "YYYY-MM-DD",
                },
                isLoading: false,
                fullPage: false,
            }
        },
        components: {
            DatePicker,
            Loading,
        },
        methods: {
            onDayClick(day) {
            }
        }
        /*
        data() {
            const month = new Date().getMonth();
            const year = new Date().getFullYear();
            return {
                masks: {
                    weekdays: 'WWW',
                },
                attributes: [
                    {
                        key: 1,
                        customData: {
                            title: 'Lunch with mom.',
                            class: 'bg-red text-white',
                        },
                        dates: new Date(year, month, 1),
                    },
                    {
                        key: 2,
                        customData: {
                            title: 'Take Noah to basketball practice',
                            class: 'bg-red  text-white',
                        },
                        dates: new Date(year, month, 2),
                    },

                ],
            };
        },
        */
    }
</script>


<style  scoped>
    /*
    ::-webkit-scrollbar {
        width: 0px;
    }
    ::-webkit-scrollbar-track {
        display: none;
    }
    .custom-calendar.vc-container {
        --day-border: 1px solid #b8c2cc;
        --day-border-highlight: 1px solid #b8c2cc;
        --day-width: 90px;
        --day-height: 90px;
        --weekday-bg: #f8fafc;
        --weekday-border: 1px solid #eaeaea;
        border-radius: 0;
        width: 100%;
    }
    .vc-header {
        background-color: #f1f5f8;
        padding: 10px 0;
    }
    .vc-weeks {
        padding: 0;
    }
    .vc-weekday {
        background-color: var(--weekday-bg);
        border-bottom: var(--weekday-border);
        border-top: var(--weekday-border);
        padding: 5px 0;
    }
    .vc-day {
        padding: 0 5px 3px 5px;
        text-align: left;
        height: var(--day-height);
        min-width: var(--day-width);
        background-color: white;
    }

    .weekday-1,
    .weekday-7 {
         background-color: #eff8ff;
     }

    .vc-day-dots {
        margin-bottom: 5px;
    }
    .bg-red{
        background-color: #ed64a6;
    }
   */
</style>

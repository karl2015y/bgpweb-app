    <script>
        Vue.component('v-date', {
            template: `
            <div>
             <div v-on:click="showDatepicker=false" v-if="showDatepicker" class="fixed top-0 left-0 w-screen h-screen z-10"></div>

            <div class="w-full">
                <label for="datepicker" v-text="text" class="text-gray-700"></label>
                <div class="relative mt-1">
                    <input type="hidden" :name="name" ref="date" />
                    <input v-on:click="showDatepicker = !showDatepicker" v-on:keydown.esc="showDatepicker = false"
                        type="text" readonly v-model="datepickerValue"
                        class="w-full pl-4 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                        placeholder="Select date" />

                    <div v-on:click="showDatepicker = !showDatepicker" v-on:keydown.esc="showDatepicker = false"
                        class="absolute top-0 right-0 px-3 py-2">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div class="z-10 bg-white mt-12 rounded-lg shadow-2xl p-4 absolute top-0 left-0" style="width: 17rem"
                        v-show.transition="showDatepicker">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <span v-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                                <span v-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                            </div>
                            <div>
                                <button type="button"
                                    class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                                    v-on:click="year=(month-1)<0?year-1:year; month=(month-1)<0?11:month-1; getNoOfDays()">
                                    <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                                     v-on:click="year=(month+1)>11?year+1:year; month=((month+1) % 12); getNoOfDays()">
                                    <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-wrap mb-3 -mx-1">
                            <template v-for="day in DAYS">
                                <div style="width: 14.26%" class="px-1">
                                    <div v-text="day" class="text-gray-800 font-medium text-center text-xs">
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="flex flex-wrap -mx-1">
                            <template v-for="blankday in blankdays">
                                <div style="width: 14.28%" class=" text-center border p-1 border-transparent text-sm">
                                </div>
                            </template>
                            <template v-for="date in no_of_days">
                                <div style="width: 14.28%" class="px-1 mb-1">
                                    <div v-on:click="getDateValue(date)" v-text="date"
                                        class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100"
                                        :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false, 'shadow border-solid border-t border-gray-300' :isPickday(date)}">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            </div>`,
            props: ['name', 'text', 'init_date'],
            data: function() {
                return {
                    MONTH_NAMES: [
                        "一月",
                        "二月",
                        "三月",
                        "四月",
                        "五月",
                        "六月",
                        "七月",
                        "八月",
                        "九月",
                        "十月",
                        "十一月",
                        "十二月",
                    ],
                    DAYS: ["日", "一", "二", "三", "四", "五", "六"],
                    showDatepicker: false,
                    datepickerValue: "",
                    month: "",
                    year: "",
                    no_of_days: [],
                    blankdays: [],
                    days: ["日", "一", "二", "三", "四", "五", "六"],
                };
            },
            created: function() {
                this.initDate()
                this.getNoOfDays()
            },
            mounted: function() {
                let today = this.init_date ? new Date(this.init_date) : new Date();
                this.$refs.date.value =
                    today.getFullYear() +
                    "-" +
                    ("0" + (today.getMonth() + 1)).slice(-2) +
                    "-" +
                    ("0" + today.getDate()).slice(-2);
            },
            methods: {
                initDate() {
                    let today = this.init_date ? new Date(this.init_date) : new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.datepickerValue = new Date(
                        this.year,
                        this.month,
                        today.getDate()
                    ).toLocaleDateString();
                },

                isToday(date) {
                    const today = new Date(this.datepickerValue);
                    const d = new Date(this.year, this.month, date);

                    return today.toDateString() === d.toDateString() ? true : false;
                },

                isPickday(date) {
                    const pickday = new Date();
                    const d = new Date(this.year, this.month, date);

                    return pickday.toDateString() === d.toDateString() ? true : false;
                },

                getDateValue(date) {
                    let selectedDate = new Date(this.year, this.month, date);
                    this.datepickerValue = selectedDate.toLocaleDateString();

                    this.$refs.date.value =
                        selectedDate.getFullYear() +
                        "-" +
                        ("0" + (selectedDate.getMonth() + 1)).slice(-2) +
                        "-" +
                        ("0" + selectedDate.getDate()).slice(-2);

                    console.log(this.$refs.date.value);

                    this.showDatepicker = false;
                },

                getNoOfDays() {
                    let daysInMonth = new Date(
                        this.year,
                        this.month + 1,
                        0
                    ).getDate();

                    // find where to start calendar day of week
                    let dayOfWeek = new Date(this.year, this.month).getDay();
                    let blankdaysArray = [];
                    for (var i = 1; i <= dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }

                    let daysArray = [];
                    for (var i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.blankdays = blankdaysArray;
                    this.no_of_days = daysArray;
                },
            }, // ...以及其他選項、各種 lifecycle hooks 等
        });
    </script>
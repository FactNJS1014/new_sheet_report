<template>

    <div class="flex justify-center mt-10">
        <div class="w-3/4 p-10 rounded-lg shadow-lg bg-slate-50">
            <h3 class="text-2xl font-semibold text-center text-blue-700">ฟอร์มเรียกดูรายงาน</h3>
            <form @submit.prevent="submitForm">
                <div class="flex-grow mt-5 space-y-5">

                    <div class="flex justify-center">
                        <div class="w-3/4 join">
                            <span
                                class="w-full p-3 text-xl font-medium bg-blue-100 border border-blue-600 rounded-l-md">Work
                                Zone (ส่วนการทำงาน) </span>
                            <select
                                class="w-full text-xl font-medium text-center border border-blue-600 join-item rounded-r-md"
                                v-model="forms.zone" @change="sendValue">
                                <option value="" disabled selected>กรุณาเลือก Work Zone</option>
                                <option v-for="zone in workZones" :key="zone.MPDZONE_ID" :value="zone.MPDZONE_ID">{{
                                    zone.MPDZONE_ID }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <div class="w-3/4 join">
                            <span
                                class="w-full p-3 text-xl font-medium bg-blue-100 border border-blue-600 rounded-l-md">
                                Line No. (หมายเลขไลน์) </span>
                            <select
                                class="w-full text-xl font-medium text-center border border-blue-600 join-item rounded-r-md"
                                v-model="forms.line">
                                <option value="" disabled selected>กรุณาเลือก Line ID.</option>
                                <option v-for="linedata in lines" :key="linedata.MLINE_ID" :value="linedata.MLINE_ID">
                                    {{ linedata.MLINE_NAME }}</option>

                            </select>

                        </div>

                    </div>

                    <div class="flex justify-center">
                        <div class="w-3/4 join">
                            <span
                                class="w-full p-3 text-xl font-medium bg-blue-100 border border-blue-600 rounded-l-md">
                                Production Shift (รหัสกะงาน) </span>
                            <select
                                class="w-full text-xl font-medium text-center border border-blue-600 join-item rounded-r-md"
                                v-model="forms.pshift">
                                <option value="" disabled selected>กรุณาเลือกกะงาน</option>
                                <option value="A">A</option>
                                <option value="B">B</option>

                            </select>

                        </div>

                    </div>
                    <div class="flex justify-center">
                        <div class="w-3/4 join">
                            <span
                                class="w-full p-3 text-xl font-medium bg-blue-100 border border-blue-600 rounded-l-md">
                                Report Date (วันที่รายงาน)</span>
                           <input type="date" v-model="forms.date" class="w-full text-xl font-medium text-center border border-blue-600 join-item rounded-r-md">

                        </div>

                    </div>

                </div>
                <div class="flex justify-center">
                    <button type="submit"
                        class="w-1/4 p-3 mt-5 text-xl font-medium text-white bg-blue-600 rounded-md join-item">
                        เรียกรายงาน
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {

    data() {
        return {
            forms:{
                zone: '',
                line: '',
                pshift: '',
                date: '',
            },
            workZones: [],
            lines: [],
        };
    },
    mounted() {
        this.fetchWorkZones();
        const datenow = new Date();
        this.forms.date = datenow.toISOString().split('T')[0]; // Convert date to ISO format

    },
    methods: {
        fetchWorkZones() {
            axios.get('/new_sheet_report/api/get/zone')
                .then(response => {
                    this.workZones = response.data;

                })
                .catch(error => {
                    console.log(error);
                });
        },

        sendValue() {
            console.log("Selected Zone:", this.forms.zone);

            if (!this.forms.zone) {
                console.warn("Zone is empty. Please select a value.");
                return;
            }

            axios.post('/new_sheet_report/send/zone',
                { zone: this.forms.zone },  // Send data in the request body
                { headers: { 'Content-Type': 'application/json' } } // Optional headers
            )
                .then(res => {
                    console.log("Response:", res.data);
                    this.lines = res.data;
                })
                .catch(error => {
                    console.error("Error sending value:", error);
                });
        },
        submitForm() {
            //console.log("Form submitted:", this.forms);
            localStorage.setItem("form", JSON.stringify(this.forms))
            this.$router.push('/choose');
        }


    }
}
</script>

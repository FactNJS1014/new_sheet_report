<template>
    <div class="flex justify-center mt-5">
        <ul class="space-x-10 menu lg:menu-horizontal">
            <li>
                <router-link to="/" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[ic--baseline-assignment] size-9"></span>
                    ฟอร์มเรียกรายงาน
                    
                </router-link>
            </li>
            <li>
                <router-link to="/choose" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--list-alt] size-9"></span>
                    เลือกรายงาน
                    
                </router-link>
            </li>
            <li>
                <router-link to="/report" active-class="text-xl font-semibold text-white bg-blue-500 hover:bg-slate-200 hover:text-blue-500">
                    <span class="icon-[material-symbols--bar-chart-4-bars] size-9"></span>
                    รายงานที่เลือก
                    
                </router-link>

            </li>
        </ul>
    </div>
</template>
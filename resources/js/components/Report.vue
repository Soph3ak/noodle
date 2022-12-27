<template>
    <div class="mt-2 report">

        <div class="search-block" id="search-block">
            <div class="position-relative">
                <div class="search pointer d-flex align-items-center">
                    <i class="ion-search"></i>
                    <p class="mb-0 ml-2">{{placeholder}}</p>
                    <span
                        v-if="placeholder!=='Search invoice number here ...'"
                        class="pointer ml-auto"
                        style="font-size: 14px"
                        @click="clearSearch(); retrieveReports(); $event.stopPropagation();">
                        <i class="ion-android-cancel"></i>
                    </span>
                </div>
                <!--Search pop-up-->
                <div id="search-pop-up" class="pop-up search-report p-3 collapse" style="width: 418px">
                    <!--Search Input-->
                    <div class="search-input px-2">
                        <div class="d-flex align-items-center" style="font-size: 14px">
                            <i class="ion-search" style="font-size: 18px"></i>
                            <input
                                type="text"
                                class="form-control search"
                                placeholder="Search invoice number here ..."
                                v-model="searchTitle"
                                @keyup.enter="handleSearchEnterPressed()"
                                @input="getSearchResult"
                            >
                            <span
                                class="pointer"
                                style="font-size: 18px"
                                @click="clearSearch(); hideSearch() ; $event.stopPropagation();">
                                <i class="ion-android-cancel"></i>
                            </span>
                        </div>
                    </div>

                    <!--Popular-->
                    <div class="popular mt-2">
                        <p class="small px-2 mb-2">Popular <i class="ion-fireball text-orange ml-1"></i></p>
                        <ul class="list-group">
                            <li class="list-group-item p-0 border-0">
                                <a href="" class="active">
                                    <img src="/files/1617328949.129465.តុំយាំគ្រឿងសមុទ្រ.jpg" alt="" width="25px" height="25px" class="rounded-circle mr-1">
                                    Cras justo odio
                                </a>
                            </li>
                            <li class="list-group-item p-0 border-0">
                                <a href="" class="">
                                    <img src="/files/1617328949.129465.តុំយាំគ្រឿងសមុទ្រ.jpg" alt="" width="25px" height="25px" class="rounded-circle mr-1">
                                    Cras justo odio
                                </a>
                            </li>
                            <li class="list-group-item p-0 border-0">
                                <a href="" class="">
                                    <img src="/files/1617328949.129465.តុំយាំគ្រឿងសមុទ្រ.jpg" alt="" width="25px" height="25px" class="rounded-circle mr-1">
                                    Cras justo odio
                                </a>
                            </li>
                            <li class="list-group-item p-0 border-0">
                                <a href="" class="">
                                    <img src="/files/1617328949.129465.តុំយាំគ្រឿងសមុទ្រ.jpg" alt="" width="25px" height="25px" class="rounded-circle mr-1">
                                    Cras justo odio
                                </a>
                            </li>
                            <li class="list-group-item p-0 border-0">
                                <a href="" class="">
                                    <img src="/files/1617328949.129465.តុំយាំគ្រឿងសមុទ្រ.jpg" alt="" width="25px" height="25px" class="rounded-circle mr-1">
                                    Cras justo odio
                                </a>
                            </li>
                            <li class="list-group-item p-0 border-0">
                                <a href="" class="">
                                    <img src="/files/1617328949.129465.តុំយាំគ្រឿងសមុទ្រ.jpg" alt="" width="25px" height="25px" class="rounded-circle mr-1">
                                    Cras justo odio
                                </a>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!--<div class="recordShowing text-lightgray" v-show="reportCount>0">
            <small>Showing {{ showingFrom() }}-{{ showingTo() }} of {{ totalRecords }} {{ totalRecords > 1 ? 'records':'record' }}</small>
        </div>-->
        <div class="d-flex justify-content-between">
            <h1 class="mb-0">ទំព័រដើម</h1>
            <div class="d-flex align-items-center ml-3">
                <span class="badge badge-warning badge-filter text-primary pr-2 animate__animated animate__bounceIn" v-show="selected.filters.length>0">
                    <i class="fas fa-filter ml-1 mr-1"></i> Filter
                </span>
                <span class="badge badge-filter selected-filter ml-1 pointer animate__animated animate__bounceIn" :id="f+'-filter'" v-for="f in selected.filters" :key="f.id">
                    <span class="text-lowercase" @click="toggleFilter(f+'-filter'); previousSelect(f+'-filter'); closeOtherFilter(f+'-filter');"><i class="fas fa-filter ml-1 mr-1"></i> {{f}}</span>
                    <button @click="btnRemoveBadgeFilter(f+'-filter'); " type="button" class="btn btn-tool"><i class="fas fa-times"></i></button>
                </span>
                <span class="badge badge-filter text-danger pr-2 pointer animate__animated animate__bounceIn" v-show="selected.filters.length>1">
                    <span @click="btnRemoveBadgeFilter('all')"><i class="fas fa-broom ml-1 mr-1"></i>Clear all filter</span>
                </span>
            </div>
            <div id="reportrange"
                 class="form-control text-center ml-auto align-self-center"
                 style="background: #fff; cursor: pointer; border: 1px solid #ccc; width: 296px">
                <i class="fa fa-calendar text-primary"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
        <div class="row" style="margin-top: 14px">
            <div class="col-12">
                <div class="card table-block border-light pt-0">
                    <!--<div class="card-header d-flex align-items-center">
                        <div class="show-page-calendar">
                            <div class="d-flex" style="width: 1050px;">
                                <label for="" class="col-form-label" style="width: 115px">Show records:</label>
                                <div class="">
                                    <select v-model="pageSize" @change="handlePageSizeChange($event)" class="form-control show-per-page" style="width: 75px">
                                        <option v-for="size in pageSizes" :key="size" :value="size">
                                            {{ size }}
                                        </option>
                                    </select>
                                </div>
                                <div id="reportrange" style="background: #fff; cursor: pointer; border: 1px solid #ccc; width: 296px" class="form-control text-center ml-2 mr-2">
                                    <i class="fa fa-calendar text-primary"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-warning badge-filter text-primary pr-2 animate__animated animate__bounceIn" v-show="selected.filters.length>0">
                                        <i class="fas fa-filter ml-1 mr-1"></i> Filter
                                    </span>
                                    <span class="badge badge-filter selected-filter ml-1 pointer animate__animated animate__bounceIn" :id="f+'-filter'" v-for="f in selected.filters" :key="f.id">
                                        <span class="text-lowercase" @click="toggleFilter(f+'-filter'); previousSelect(f+'-filter'); closeOtherFilter(f+'-filter');"><i class="fas fa-filter ml-1 mr-1"></i> {{f}}</span>
                                        <button @click="btnRemoveBadgeFilter(f+'-filter'); " type="button" class="btn btn-tool"><i class="fas fa-times"></i></button>
                                    </span>
                                    <span class="badge badge-filter text-danger pr-2 pointer animate__animated animate__bounceIn" v-show="selected.filters.length>1">
                                        <span @click="btnRemoveBadgeFilter('all')"><i class="fas fa-broom ml-1 mr-1"></i>Clear all filter</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="paginate ml-auto">
                            <pagination :data="reports"
                                        @pagination-change-page="handlePageChange"
                                        :limit="1"
                                        :show-disabled="true"
                                        :total-rows="count"
                                        :per-page="pageSize"
                                        align="center">
                                <span slot="prev-nav" class="p-2">Previous</span>
                                <span slot="next-nav" class="p-2">Next</span>
                            </pagination>
                        </div>
                    </div>-->
                    <div class="card-body table-responsive p-0" style="max-height: 76vh; min-height: 76vh;">
                        <div class="">
                            <loading :active.sync="isLoading"
                                     :can-cancel="true"
                                     :is-full-page="fullPage"
                                     :height="height"
                                     :width="width"
                                     :color="color"
                                     :loader="loader"
                                     :background-color="bgColor"></loading>
                        </div>
                        <table class="table table-head-fixed text-nowrap sell-reports">
                            <thead>
                            <tr class="w-100">
                                <th>
                                    <span class="gg pointer"  @click="sortBy('id')" id="column_id">
                                        Invoice #
                                        <!--<span class="text-gray ml-1"><i class="gg-swap-vertical"></i></span>-->
                                        <span class="sort sort-default ml-1"></span>
                                    </span>
                                </th>
                                <th>
                                    <span class="gg pointer" @click="sortBy('date')" id="column_date">
                                        Date
                                       <!-- <span class="text-gray ml-2"><i class="gg-swap-vertical"></i></span>-->
                                        <span class="sort sort-default ml-1"></span>
                                    </span>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <span class="gg pointer" @click="sortBy('customer')" id="column_customer">
                                            Customer
                                            <!--<span class="text-gray ml-1"><i class="gg-swap-vertical"></i></span>-->
                                            <span class="sort sort-default ml-1"></span>
                                        </span>
                                        <div class="position-relative pointer d-inline-block">
                                            <span class="gg">
                                                <span class="btn-filter text-gray btn-customer-filter" @click="toggleFilter('customer-filter'); previousSelect('customer-filter'); closeOtherFilter('customer-filter');"><i class="gg-sort-az"></i></span>
                                            </span>
                                            <div class="filter customer-filter px-2 py-4 d-none">
                                                <span class="p-2 pointer text-primary" @click="selectAll('customer-filter')"><i class="ion-android-done-all mr-2"></i>Select all</span>
                                                <span class="p-2 pointer text-danger" @click="clearSelect('customer-filter')"><i class="ion-android-close mr-2"></i>Clear</span>
                                                <hr>
                                                <div class="form-group">
                                                    <div class="checkbox-wrapper px-2" v-for="cus in customers" :key="cus.id" :id="'customer-wrapper' + cus.id">
                                                        <div class="custom-control custom-checkbox d-flex align-items-center">
                                                            <input class="custom-control-input" type="checkbox" v-model="selected.customers" :id="'customer' + cus.id" :value="cus"/>
                                                            <label :for="'customer' + cus.id" class="custom-control-label pointer">{{cus.name}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="filter_footer d-flex justify-content-end">
                                                    <button @click="closeFilter('customer-filter'); previousSelect('customer-filter')" type="button" id="close-customer-filter" class="btn btn-sm btn-default mr-2">Cancel</button>
                                                    <button @click="applyFilter('customer-filter'); saveSelect('customer-filter')" type="button" class="btn btn-sm btn-success">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>Location</th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <span class="gg pointer" @click="sortBy('seller')" id="column_seller">
                                            Seller
                                            <!--<span class="text-gray ml-1"><i class="gg-swap-vertical"></i></span>-->
                                            <span class="sort sort-default ml-1"></span>
                                        </span>
                                        <div class="position-relative pointer d-inline-block">
                                            <span class="gg pointer">
                                                <span class="btn-filter text-gray btn-seller-filter" @click="toggleFilter('seller-filter'); previousSelect('seller-filter'); closeOtherFilter('seller-filter');"><i class="gg-sort-az"></i></span>
                                            </span>
                                            <div class="filter seller-filter px-2 py-4 d-none">
                                                <span class="p-2 pointer text-primary" @click="selectAll('seller-filter')"><i class="ion-android-done-all mr-2"></i>Select all</span>
                                                <span class="p-2 pointer text-danger" @click="clearSelect('seller-filter')"><i class="ion-android-close mr-2"></i>Clear</span>
                                                <hr>
                                                <div class="form-group">
                                                    <div class="checkbox-wrapper px-2" v-for="s in sellers" :key="s.id" :id="'seller-wrapper' + s.id">
                                                        <div class="custom-control custom-checkbox d-flex align-items-center">
                                                            <input class="custom-control-input" type="checkbox" v-model="selected.sellers" :id="'seller' + s.id" :value="s"/>
                                                            <label :for="'seller' + s.id" class="custom-control-label pointer">{{s.name_kh}}</label>
                                                            <span class="filter-avatar ml-auto mt-auto"><img :src="'files/'+s.photo" alt="" class="img-circle staff-image"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="filter_footer d-flex justify-content-end">
                                                    <button @click="closeFilter('seller-filter'); previousSelect('seller-filter')" type="button" id="close-seller-filter" class="btn btn-sm btn-default mr-2">Cancel</button>
                                                    <button @click="applyFilter('seller-filter'); saveSelect('seller-filter')" type="button" class="btn btn-sm btn-success">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <span class="gg pointer" @click="sortBy('table')" id="column_table">
                                            Table
                                            <!--<span class="text-gray ml-1"><i class="gg-swap-vertical"></i></span>-->
                                            <span class="sort sort-default ml-1"></span>
                                        </span>

                                        <div class="position-relative pointer d-inline-block">
                                            <span class="gg">
                                                <span class="btn-filter text-gray btn-table-filter" @click="toggleFilter('table-filter'); previousSelect('table-filter'); closeOtherFilter('table-filter');"><i class="gg-sort-az"></i></span>
                                            </span>
                                            <div class="filter table-filter px-2 py-4 d-none">
                                                <span class="p-2 pointer text-primary" @click="selectAll('table-filter')"><i class="ion-android-done-all mr-2"></i>Select all</span>
                                                <span class="p-2 pointer text-danger" @click="clearSelect('table-filter')"><i class="ion-android-close mr-2"></i>Clear</span>
                                                <hr>
                                                <div class="form-group px-2">
                                                    <div class="checkbox-wrapper px-2" v-for="t in tables" :key="t.id">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" v-model="selected.tables" :id="'table' + t.id" :value="t"/>
                                                            <label :for="'table' + t.id" class="custom-control-label pointer">{{t.name}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="filter_footer d-flex justify-content-end">
                                                    <button @click="closeFilter('table-filter'); previousSelect('table-filter')" type="button" id="close-table-filter" class="btn btn-sm btn-default mr-2">Cancel</button>
                                                    <button @click="applyFilter('table-filter'); saveSelect('table-filter')" type="button" class="btn btn-sm btn-success">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <span class="gg pointer" @click="sortBy('payment')" id="column_payment">
                                            Payment
                                            <!--<span class="text-gray ml-1"><i class="gg-swap-vertical"></i></span>-->
                                            <span class="sort sort-default ml-1"></span>
                                        </span>
                                        <div class="position-relative pointer d-inline-block">
                                            <span class="gg">
                                                <span class="btn-filter text-gray btn-payment-filter" @click="toggleFilter('payment-filter'); previousSelect('payment-filter'); closeOtherFilter('payment-filter')"><i class="gg-sort-az"></i></span>
                                            </span>
                                            <div class="filter payment-filter px-2 py-4 d-none">
                                                <span class="p-2 pointer text-primary" @click="selectAll('payment-filter')"><i class="ion-android-done-all mr-2"></i>Select all</span>
                                                <span class="p-2 pointer text-danger" @click="clearSelect('payment-filter')"><i class="ion-android-close mr-2"></i>Clear</span>
                                                <hr>
                                                <div class="form-group px-2">
                                                    <div class="checkbox-wrapper px-2" v-for="p in paymentTypes" :key="p.id">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" v-model="selected.paymentTypes" :id="'payment' + p.id" :value="p"/>
                                                            <label :for="'payment' + p.id" class="custom-control-label pointer">{{p.payment}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="filter_footer d-flex justify-content-end">
                                                    <button @click="closeFilter('payment-filter'); previousSelect('payment-filter')" type="button" id="close-payment-filter" class="btn btn-sm btn-default mr-2">Cancel</button>
                                                    <button @click="applyFilter('payment-filter'); saveSelect('payment-filter')" type="button" class="btn btn-sm btn-success">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <span class="gg pointer" @click="sortBy('subtotal')" id="column_subtotal">
                                        Subtotal
                                        <!--<span class="text-gray ml-1"><i class="gg-swap-vertical"></i></span>-->
                                        <span class="sort sort-default ml-1"></span>
                                    </span>
                                </th>
                                <th>
                                    <span class="gg pointer" @click="sortBy('discount')" id="column_discount">
                                        Discount
                                        <!--<span class="text-gray ml-1"><i class="gg-swap-vertical"></i></span>-->
                                        <span class="sort sort-default ml-1"></span>
                                    </span>
                                </th>
                                <th>
                                    <span class="gg pointer" @click="sortBy('total')" id="column_total">
                                        Total
                                        <!--<span class="text-gray ml-1"><i class="gg-swap-vertical"></i></span>-->
                                        <span class="sort sort-default ml-1"></span>
                                    </span>
                                </th>
                                <th class="text-center reset-table">
                                    <span v-show="showingBtnResetTable === true || selected.filters.length > 0"  @click="resetTable" class="text-danger pointer text-xs animate__animated animate__bounceIn">
                                        <i v-if="btnResetTableLoading === true" class="fas fa-spinner mr-2 fa-spin"></i>
                                        <i v-else class="fas fa-undo mr-2s mr-2"></i>
                                        Reset table
                                    </span>
                                </th>
                            </tr>
                            </thead>

                            <tbody v-for="report in reports.data" :key="report.id" :id="'report'+report.id">
                            <tr class="tr-show-sub" @click="toggleSlideTable(report.id); showDetail(report.id)">
                                <td><a href="#">{{ report.id }}</a></td>
                                <td>{{ formatDate(report.created_at) }}</td>
                                <td>{{ report.customer.name }}</td>
                                <td>{{ report.shop.name_kh }}</td>
                                <td>
                                    <div class="position-relative p-0">
                                        <img :src="getImgUrl(report.user.photo)" alt="Staff Image" class="img-circle staff-image">
                                    </div>
                                </td>
                                <td>{{ report.table.name }}</td>
                                <td>
                                    <span class="badge badge-new-primary" v-if="report.payment.payment === 'UNPAID'">UNPAID</span>
                                    <span class="badge badge-new-success" v-else-if="report.payment.payment === 'PAID'">PAID</span>
                                    <span class="badge badge-new-danger" v-else>VOID</span>
                                </td>
                                <td class="">{{ convertToCurrency(report.subtotal) }}<span class="kh-currency"><span class="kh-currency">៛</span></span></td>
                                <td class="text-danger">-{{ convertToCurrency(report.discount) }}<span class="kh-currency">៛</span></td>
                                <td class="text-success">{{ convertToCurrency(report.total) }}<span class="kh-currency">៛</span></td>
                                <td class="text-right toggle-detail">
                                    <span>
                                        <a type="button" class="btn btn-detail">
                                            <!--<i class="ion-code-working text-cyan"></i>-->
                                            <i class="ion-chevron-down text-cyan"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr class="tr-sub" :id="'detail'+report.id">
                                <td colspan="11" class="abc">
                                    <div class="row div-sub">
                                        <div class="col-md-12">
                                            <!-- The time line -->
                                            <div class="timeline">
                                                <div>
                                                    <i class="fas fa-shopping-cart bg-green"></i>
                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header"><a href="#">Order #{{report.id}}</a></h3>
                                                        <!--<span class="text-xs ml-2 text-success">Showing 5 of 9 products</span>-->
                                                        <table class="table table-borderless table-valign-middle">
                                                            <tbody v-if="loadingProducts === true && report.products.length<=0" class="skeleton">
                                                                <tr v-for="i in 3">
                                                                    <td>
                                                                        <span class="mask-squircle mr-2 placeholder avatar mr-2"> </span>
                                                                        <span class="placeholder line"></span>
                                                                    </td>
                                                                    <td v-for="j in 4">
                                                                        <span class="placeholder line"></span>
                                                                    </td>
                                                                </tr>

                                                            </tbody>

                                                            <tr v-for="(product,index) in report.products" :key="product.id" v-if="index < report.products.length-1" class="fade-in">

                                                                <td>
                                                                    <img :src="'files/'+product.photo" alt="Product 1" class="mask-squircle mr-2">
                                                                    {{product.name_kh}}
                                                                </td>

                                                                <td>
                                                                    <small class="text-success mr-1">
                                                                        Quantity
                                                                    </small>
                                                                    {{product.pivot.quantity}}
                                                                </td>

                                                                <td>
                                                                    <small class="text-success mr-1">
                                                                        Unit price
                                                                    </small>
                                                                    {{convertToCurrency(product.price)}}<span class="kh-currency"><span class="kh-currency">៛</span></span>
                                                                </td>
                                                                <td>
                                                                    <small class="text-success mr-1">
                                                                        Amount
                                                                    </small>
                                                                    {{convertToCurrency(product.price * product.pivot.quantity)}}<span class="kh-currency"><span class="kh-currency">៛</span></span>
                                                                </td>
                                                                <td>
                                                                    <small class="text-success mr-1">
                                                                        Discount
                                                                    </small>
                                                                    <span class="text-danger">
                                                                            -{{convertToCurrency(product.pro_discount * product.pivot.quantity)}}<span class="kh-currency">៛</span>
                                                                        </span>
                                                                </td>
                                                            </tr>


                                                        </table>
                                                        <div class="timeline-footer ml-2 d-flex justify-content-between">
                                                           <div>
                                                               <a class="text-primary pointer" v-if="loadingButton === true && report.id === ordID">
                                                                   <i class="fas fa-spinner mr-2 fa-spin"></i> Loading
                                                               </a>

                                                               <a class="text-primary pointer"
                                                                  @click="showAllDetailProduct(report.id ,report.products[report.products.length-1])"
                                                                  v-else-if="report.products[report.products.length-1] > report.products.length-1">
                                                                   Show all {{report.products[report.products.length-1]}} products
                                                               </a>
                                                           </div>

                                                            <div>
                                                                <a :href="'/print/'+report.id" target="_blank" class="btn btn-sm btn-outline-primary border-0">Print</a>
                                                                <button class="btn btn-sm btn-outline-primary border-0" @click="toggleSlideTable(report.id)">Hide</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->

                                                <div>
                                                    <i class="fas fa-ban bg-gray" v-if="report.products[report.products.length-1] <= 5 || report.products.length-1 > 5"></i>
                                                    <i class="fas fa-angle-double-down bg-gray animated-down" :id="'ban'+report.id" v-else></i>
                                                    <span class="text-xs ml-5 pl-3 text-lightgray">
                                                        <span v-if="report.products.length<1">Loading products...</span>
                                                        <span v-else>Showing {{report.products.length-1}} of {{report.products[report.products.length-1]}}
                                                        {{report.products[report.products.length-1]>1 ? 'products':'product'}}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tbody v-show="reportCount === 0">
                            <tr class="bg-white">
                                <td class="" colspan="10">
                                    <div class="sc-5kpu8c-5 dcdHhK">
                                        <div class="sc-5kpu8c-6 fbNBuP mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="24px" width="24px" viewBox="0 0 24 24" class="sc-16r8icm-0 jZwKai">
                                                <path d="M16.4153 16.4153L20 20M18.5455 11.2727C18.5455 15.2893 15.2894 18.5454 11.2728 18.5454C7.25612 18.5454 4 15.2893 4 11.2727C4 7.2561 7.25612 4 11.2728 4C15.2894 4 18.5455 7.2561 18.5455 11.2727Z" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </div>
                                        <h3 font-size="16px" font-weight="500" color="text" class="sc-1eb5slv-0 ddqQcN" style="text-align: center;">No results found</h3>
                                        <p color="text2" font-size="1" class="sc-1eb5slv-0 bSDVZJ">We couldn't find anything matching your search.</p>
                                        <p color="text2" font-size="1" class="sc-1eb5slv-0 bSDVZJ">Try again with a different term.</p>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <label for="" class="col-form-label" style="width: 115px"><small>Show records:</small></label>
                            <div class="">
                                <select v-model="pageSize" @change="handlePageSizeChange($event)" class="form-control show-per-page" style="width: 75px">
                                    <option v-for="size in pageSizes" :key="size" :value="size">
                                        {{ size }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="recordShowing1 text-lightgray ml-2" v-show="reportCount>0">
                            <small>Showing {{ showingFrom() }}-{{ showingTo() }} of {{ totalRecords }} {{ totalRecords > 1 ? 'records':'record' }}</small>
                        </div>

                        <div class="ml-auto">
                            <div class="paginate">
                                <pagination :data="reports"
                                            @pagination-change-page="handlePageChange"
                                            :limit="1"
                                            :show-disabled="false"
                                            :total-rows="count"
                                            :per-page="pageSize"
                                            align="center">
                                    <span slot="prev-nav" class="p-2">Prev</span>
                                    <span slot="next-nav" class="p-2">Next</span>
                                </pagination>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->

            </div>
        </div>
        <!-- /.row -->
    </div>
</template>

<script>

/*https://github.com/ankurk91/vue-loading-overlay/tree/v3.x*/
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    props: ['token'],
    components:{Loading },

    data () {
        return {
            currentPage:'1',
            reports:{},
            reportCount:1,
            placeholder: 'Search invoice number here ...',

            searchTitle: "",
            page: 1,
            count: 0,
            pageSize: 10,
            pageSizes: [10, 25, 50, 100],
            totalRecords: 0,
            start: null,
            end: null,

            isLoading: false,
            fullPage: false,
            canCancel: true,
            loader: 'dots',
            color: '#007bff',
            bgColor: '#ffffff',
            height: 70,
            width: 70,

            tables:[], // Only for render to checkbox filter card
            tablesCount : 0,
            tblID:{
                tablesID: ['all']
            },

            paymentTypes:[],
            paymentCount : 0,
            paymentID:{
                //for request filters
                paymentsID: ['all']
            },

            sellers:[],
            sellersCount : 0,
            sellerID:{
                //for request filters
                sellersID: ['all']
            },

            customers:[],
            customersCount : 0,
            customerID:{
                //for request filters
                customersID: ['all']
            },


            selected: {
                filters: [], // For render filters badge
                tables: [], //  Related to checkbox filters had selected or hadn't selected
                tempTables: [], //  Keep latest checkbox selected values, if in case the user playing around filters checkbox
                                //  then CANCEL instead of APPLY so we will show the latest selected values after latest apply
                paymentTypes: [],
                tempPaymentTypes: [],
                sellers: [],
                tempSeller: [],
                customers:[],
                tempCustomer:[],
            },

            detailLimit: 5,

            loadingProducts: false,
            loadingButton: false,
            ordID: 0,

            orderBy: ['id', 'desc'],    // For sort in server
            sort_by_column: '',         // Help in condition
            sort_direction: 'asc',      //Help in condition

            openedRows:[''],

            showingBtnResetTable: false,
            btnResetTableLoading: false,

            queryTimeout: null,

        }
    },
    methods:{

        /*=========Axios with filter: https://www.bezkoder.com/vue-pagination-axios/========*/

        getAll(params) {
            return axios.get("/getReport", {params});
        },

        getRequestParams(searchTitle, page, pageSize, start, end, paymentTypes, tables, sellers, customers, orderBy) {
            let params = {};
            if (searchTitle) {
                params["title"] = searchTitle;
            }

            if (page) {
                params["page"] = page;
            }

            if (pageSize) {
                params["size"] = pageSize;
            }

            if (start) {
                params["start"] = start;
            }
            if (end) {
                params["end"] = end;
            }
            if (paymentTypes) {
                params["paymentTypes"] = paymentTypes;
            }
            if (tables) {
                params["tables"] = tables;
            }
            if (sellers) {
                params["sellers"] = sellers;
            }
            if (customers) {
                params["customers"] = customers;
            }

            if (orderBy) {
                params["orderBy"] = orderBy;
            }

            return params;

        },

        retrieveReports() {
            this.closeOpenedRows() // To slide up all rows which opened products detail *Error case #1
            const params = this.getRequestParams(
                this.searchTitle,
                this.page,
                this.pageSize,
                this.start,
                this.end,
                this.paymentID.paymentsID,
                this.tblID.tablesID,
                this.sellerID.sellersID,
                this.customerID.customersID,
                this.orderBy,
            );
            this.isLoading = true;
            setTimeout(() => {
                this. getAll(params)
                    .then((response) => {
                        this.isLoading = false
                        this.reports = response.data
                        this.reportCount = (this.reports.data).length
                        this.totalRecords = this.reports.total
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            }, 1)

        },

        showingFrom(){
            return this.pageSize*(this.page-1)+1;
        },

        showingTo(){
            let showUntil = this.pageSize*this.page;
            return (showUntil < this.totalRecords ? showUntil:this.totalRecords);
        },

        handlePageChange(value) {
            if (this.page !== value){
                this.page = value;
                this.retrieveReports();
            }

        },

        handlePageSizeChange(event) {
            this.pageSize = event.target.value;
            this.page = 1;
            this.retrieveReports();
        },

        /*handlePaymentChange(event){
            this.paymentType = event.target.value;
            this.page = 1;
            this.retrieveReports();
        },*/

        handleTableChange(event){
            this.table = event.target.value;
            this.retrieveReports();

        },

        formatDate(value){
            return moment(value).format("LL");
        },

        getImgUrl(img) {
            return '/files/' + img
        },

        alertSuccess(str1,name,str2){
            Toast.fire({
                icon: 'success',
                title: str1 +' '+ name +' '+ str2
            })
        },

        retrieveTables(){
            axios.get("api/loadSeats")
                .then((response) => {
                    this.tables = response.data;
                    this.tablesCount = this.tables.length
                    this.selected.tables = this.tables;
                    this.selected.tempTables = this.tables;

                })
                .catch((e) => {
                    console.log(e);
                });
        },

        convertToCurrency(price){
            /*https://flaviocopes.com/how-to-format-number-as-currency-javascript/*/
            let converted
            const formatter = new Intl.NumberFormat('en-US', {
                /*style: 'currency',
                currency: 'USD',*/
                minimumFractionDigits: 0
            })
            if(price > 0){
                return converted = formatter.format(price)
            }
            else return converted = '0.00'

        },

        toggleFilter(filter){
            if(filter!=='all'){ //this if() to skip from btn "Clear all filter" //'all' happened only when btnClearAllBadge clicked
                let filterClass = '.'+filter;
                let fil = $(filterClass);
                fil.toggleClass('d-none');
            }
        },

        closeFilter(filter){
            if (filter!=='all'){ //this if() to skip from btn "Clear all filter" //'all' happened only when btnClearAllBadge clicked
                let filterClass = '.'+filter;
                let fil = $(filterClass);
                fil.addClass('d-none');
            }
        },

        btnRemoveBadgeFilter(filter){
            this.selectAll(filter); // = all filter clicked select all
            this.applyFilter(filter);
            this.saveSelect(filter);
            this.closeFilter(filter);
            this.closeOtherFilter(filter);
        },

        removeBadgeFilter(current){
            this.selected.filters.splice(current,1);
        },

        closeOtherFilter(filter){
            let closePaymentFilter = $('#close-payment-filter');
            let closeTableFilter = $('#close-table-filter');
            let closeSellerFilter = $('#close-seller-filter');
            let closeCustomerFilter = $('#close-customer-filter');
            switch (filter) {
                case 'table-filter':
                    closePaymentFilter.trigger('click');
                    closeSellerFilter.trigger('click');
                    closeCustomerFilter.trigger('click');
                    break;
                case 'payment-filter':
                    closeTableFilter.trigger('click');
                    closeSellerFilter.trigger('click');
                    closeCustomerFilter.trigger('click');
                    break;
                case  'seller-filter':
                    closePaymentFilter.trigger('click');
                    closeTableFilter.trigger('click');
                    closeCustomerFilter.trigger('click');
                    break;
                case  'customer-filter':
                    closePaymentFilter.trigger('click');
                    closeTableFilter.trigger('click');
                    closeSellerFilter.trigger('click');
                    break;
                case  'all':
                    let closeAllFilter = $('div.filter');
                    closeAllFilter.addClass('d-none');
                    break;
                default:

            }
        },



        clearSelect(filter){
            switch (filter) {
                case 'table-filter':
                    this.selected.tables = [];
                    break;

                case 'payment-filter':
                    this.selected.paymentTypes = [];
                    break;

                case  'seller-filter':
                    this.selected.sellers = [];
                    break;

                case  'customer-filter':
                    this.selected.customers = [];
                    break;

                default:

            }

        },

        selectAll(filter){
            switch (filter) {
                case 'table-filter':
                    this.selected.tables = this.tables;
                    break;

                case 'payment-filter':
                    this.selected.paymentTypes = this.paymentTypes;
                    break;

                case  'seller-filter':
                    this.selected.sellers = this.sellers;
                    break;
                case  'customer-filter':
                    this.selected.customers = this.customers;
                    break;

                case  'all':
                    this.selected.tables = this.tables;
                    this.selected.paymentTypes = this.paymentTypes;
                    this.selected.sellers = this.sellers;
                    this.selected.customers = this.customers;
                    break;
                default:

            }

        },

        previousSelect(filter){
            switch (filter) {
                case 'table-filter':
                    this.selected.tables = this.selected.tempTables;
                    break;
                case 'payment-filter':
                    this.selected.paymentTypes = this.selected.tempPaymentTypes;
                    break;
                case  'seller-filter':
                    this.selected.sellers = this.selected.tempSeller;
                    break;
                case  'customer-filter':
                    this.selected.customers = this.selected.tempCustomer;
                    break;
                default:

            }

        },

        saveSelect(filter){
            // "saveSelect" paste value to tmp coz after save, user might select or de-select more then cancel
            // so we had to paste previous value after filter had applied
            switch (filter) {
                case 'table-filter':
                    this.selected.tempTables = this.selected.tables;
                    break;
                case 'payment-filter':
                    this.selected.tempPaymentTypes = this.selected.paymentTypes;
                    break;
                case  'seller-filter':
                    this.selected.tempSeller = this.selected.sellers;
                    break;

                case  'customer-filter':
                    this.selected.tempCustomer = this.selected.customers;
                    break;

                case  'all':
                    this.selected.tempTables = this.selected.tables;
                    this.selected.tempPaymentTypes = this.selected.paymentTypes;
                    this.selected.tempSeller = this.selected.sellers;
                    this.selected.tempCustomer = this.selected.customers;
                    break;
                default:

            }

        },

        getSelectedID(filter){
            let filterCount = 0;
            let selectedFilter = [];
            let selectedFilterLength = 0;

            switch (filter) {
                case 'table-filter':
                    filterCount = this.tablesCount;
                    selectedFilter = this.selected.tables
                    selectedFilterLength = this.selected.tables.length;
                    this.tblID.tablesID = this.sub_GetSelectedID(filterCount, selectedFilter, selectedFilterLength)
                    break;

                case 'payment-filter':
                    filterCount = this.paymentCount;
                    selectedFilter = this.selected.paymentTypes
                    selectedFilterLength = this.selected.paymentTypes.length;
                    this.paymentID.paymentsID = this.sub_GetSelectedID(filterCount, selectedFilter, selectedFilterLength)
                    break;

                case  'seller-filter':
                    filterCount = this.sellersCount;
                    selectedFilter = this.selected.sellers
                    selectedFilterLength = this.selected.sellers.length
                    this.sellerID.sellersID = this.sub_GetSelectedID(filterCount, selectedFilter, selectedFilterLength);
                    break;

                case  'customer-filter':
                    filterCount = this.customersCount;
                    selectedFilter = this.selected.customers
                    selectedFilterLength = this.selected.customers.length
                    this.customerID.customersID = this.sub_GetSelectedID(filterCount, selectedFilter, selectedFilterLength);
                    break;

                case  'all':
                    this.tblID.tablesID = ['all'];
                    this.paymentID.paymentsID = ['all'];
                    this.sellerID.sellersID = ['all'];
                    this.customerID.customersID = ['all'];
                    break;
                default:

            }

        },

        sub_GetSelectedID(count, selectedFilters, selectedLength){
            let IDs = [];
            if (selectedLength === count)
                IDs = ['all'];
            else
                selectedFilters.forEach((value, index) => {
                    IDs.push(value.id);
                });
            return IDs;
        },

        styling_BtnFilter_BadgeFilter(filter){
            let selectedFilterLength = 0;
            let filterCount = 0;
            let text = '';
            switch (filter) {
                case 'table-filter':
                    selectedFilterLength = this.selected.tables.length;
                    filterCount = this.tablesCount;
                    text = 'table';
                    this.sub_Styling_BtnFilter_BadgeFilter(filter, selectedFilterLength, filterCount, text)
                    break;

                case 'payment-filter':
                    selectedFilterLength = this.selected.paymentTypes.length;
                    filterCount = this.paymentCount;
                    text = 'payment';
                    this.sub_Styling_BtnFilter_BadgeFilter(filter, selectedFilterLength, filterCount, text)
                    break;

                case  'seller-filter':
                    selectedFilterLength = this.selected.sellers.length;
                    filterCount = this.sellersCount;
                    text = 'seller';
                    this.sub_Styling_BtnFilter_BadgeFilter(filter, selectedFilterLength, filterCount, text)
                    break;

                case  'customer-filter':
                    selectedFilterLength = this.selected.customers.length;
                    filterCount = this.customersCount;
                    text = 'customer';
                    this.sub_Styling_BtnFilter_BadgeFilter(filter, selectedFilterLength, filterCount, text)
                    break;

                case  'all':
                    let allBtnFilter = $('.btn-filter');
                    allBtnFilter.removeClass('visited');
                    this.selected.filters = [];
                    break;
                default:


            }
        },

        sub_Styling_BtnFilter_BadgeFilter(filter, length, count, badgeText){
            let currentFilter ='';
            let selectedBtnFilter = $('.btn-'+filter);
            if (length !== count){
                selectedBtnFilter.addClass('visited');

                if (this.selected.filters.length === 0){
                    this.selected.filters.push(badgeText);
                }
                else
                {
                    currentFilter = '';
                    for (let i = 0; i < this.selected.filters.length; i++) {
                        currentFilter = this.selected.filters[i];
                        if (currentFilter === badgeText)
                            break; //This break in not working (Why javascript??)
                    }
                    if (currentFilter !== badgeText)  //this if() to fix not working break
                        this.selected.filters.push(badgeText);
                }
            }
            else
            {
                selectedBtnFilter.removeClass('visited');
                this.selected.filters.forEach((value, index) => {
                    if (value === badgeText){
                        this.removeBadgeFilter(index,1)
                    }
                })

            }

        },

        applyFilter(filter){
            this.page = 1;
            this.getSelectedID(filter) //get only for ID
            this.retrieveReports()
            this.toggleFilter(filter)
            this.styling_BtnFilter_BadgeFilter(filter);
        },

        sort(column){

        },

        retrievePaymentType(){
            axios.get("getPaymentType")
                .then((response) => {
                    this.paymentTypes = response.data;
                    this.paymentCount = this.paymentTypes.length
                    this.selected.paymentTypes = this.paymentTypes;
                    this.selected.tempPaymentTypes = this.paymentTypes;
                })
                .catch((e) => {
                    console.log(e);
                });
        },

        retrieveSellers(){
            axios.get("getSellers")
                .then((response) => {
                    this.sellers = response.data;
                    this.sellersCount = this.sellers.length
                    this.selected.sellers = this.sellers;
                    this.selected.tempSeller = this.sellers;
                })
                .catch((e) => {
                    console.log(e);
                });
        },

        retrieveCustomers(){
            axios.get("getCustomers")
                .then((response) => {
                    this.customers = response.data;
                    this.customersCount = this.customers.length
                    this.selected.customers = this.customers;
                    this.selected.tempCustomer = this.customers;
                })
                .catch((e) => {
                    console.log(e);
                });
        },

        toggleSlideTable(rowID){
            const selector = $("#detail"+rowID);
            const div_sub = selector.find('div.div-sub')
            div_sub.slideToggle(350)
            selector.toggleClass('shadowed')
            let btn_detail = selector.parent('tbody').find('a.btn-detail')
            btn_detail.toggleClass('rotate_up')
        },

        closeOpenedRows(){
            this.ordID = 0 //let row click can retrieve products again

            const selector = $(".shadowed");
            selector.find('div.div-sub').slideUp(0)
            selector.removeClass('shadowed')

            let btn_detail = selector.parent('tbody').find('a.btn-detail')
            btn_detail.removeClass('rotate_up')

        },

        showDetail(orderID, limit){
            if (limit) {
                this.detailLimit = limit
            }

            if (orderID !== this.ordID) {//THIS IF() TO PREVENT FROM FAST DOUBLE CLICK (CUZ PULL REQUEST TWO TIMES)
                this.reports.data.forEach((value1, index1) => {
                    if (value1.products.length <= 0) { //Prevent Error,
                        if (value1.id === orderID) { //CHECK TO PUSH TO CORRECT ORDER ID
                            this.loadingProducts= true
                            this.ordID = orderID
                            let params = this.getParamsDetailProduct(
                                this.ordID,
                                this.detailLimit,
                            );
                            setTimeout(() => {
                                axios.get("/getOrderProducts", {params})
                                    .then((response) => {
                                        this.loadingProducts = false
                                        let arr = [];
                                        arr = response.data[0]
                                        //value1.products = []
                                        arr.forEach((value, index) => {
                                            value1.products.push(arr[index])
                                        })
                                        value1.products.push(response.data['total']);
                                    })
                                    .catch((e) => {
                                        console.log(e);
                                    });
                            }, 250);
                        }
                    }
                })
            }
        },

        getParamsDetailProduct(orderID, limit){
            let params = {};
            if (orderID) {
                params["orderID"] = orderID;
            }

            if (limit) {
                params["limit"] = limit;
            }

            return params;
        },

        showAllDetailProduct(orderID, limit){
            if (limit) {
                this.detailLimit = limit
            }
            this.reports.data.forEach((value1, index1) => {
                if (value1.id === orderID) { //CHECK TO PUSH TO CORRECT ORDER ID
                    this.loadingButton = true
                    this.ordID = orderID
                    let params = this.getParamsDetailProduct(
                        this.ordID,
                        this.detailLimit,
                    );
                    setTimeout(() => {
                        axios.get("/getOrderProducts", {params})
                            .then((response) => {
                                this.loadingButton = false
                                this.changeToBanIcon(orderID)
                                let arr = [];
                                arr = response.data[0]
                                value1.products = []
                                arr.forEach((value, index) => {
                                    value1.products.push(arr[index])
                                })
                                value1.products.push(response.data['total']);
                            })
                            .catch((e) => {
                                console.log(e);
                            });
                    }, 250);
                }

            })
            this.detailLimit = 5; //reset limit
        },

        changeToBanIcon(id){
            let select = $("i#ban"+id);
            select.addClass('fas fa-angle-double-down bg-gray')
        },

        sortBy(byColumn){
            this.page = 1
            this.showingBtnResetTable = true
            if(this.sort_direction === 'asc' || this.sort_by_column !== byColumn){
                this.sort_direction = 'desc'
                this.switchSortIcon(byColumn, 'desc')
            }
            else
            {
                this.sort_direction = 'asc'
                this.switchSortIcon(byColumn,'asc')
            }

            this.sort_by_column = byColumn

            this.orderBy=[]
            this.orderBy[0] = byColumn
            this.orderBy[1] = this.sort_direction
            this.retrieveReports();

        },

        switchSortIcon(byColumn, direction){
            let selector = $("#column_"+byColumn)
            let selectorActiveIcon = $("span.sort.active")
            let sort = selector.find('span.sort')

            selectorActiveIcon.addClass('default')
            selectorActiveIcon.removeClass('active sort-asc sort-desc')

            if (direction === 'asc')
                sort.addClass('sort-asc active')
            else if (direction === 'desc')
                sort.addClass('sort-desc active')
        },

        resetTable(){
            this.btnResetTableLoading = true
            setTimeout(()=>{
                this.page = 1
                this.orderBy = ['id','desc']
                this.sort_by_column = ''
                this.sort_direction = 'asc'
                this.switchSortIcon('id', 'default')
                this.btnRemoveBadgeFilter('all') // = "Remove all filters" clicked (already has retrieveReports() inside)
                this.btnResetTableLoading = false
                this.showingBtnResetTable = false
            },250)

        },

        clearSearch(){
            if (this.searchTitle !== ''){
                this.searchTitle=''
                this.placeholder = 'Search invoice number here ...'
                this.retrieveReports()
            }
        },

        hideSearch(){
            let search = $("#search-pop-up")
            search.addClass('collapse')
        },

        setSearchTitle(){
            this.placeholder = this.searchTitle
        },

        getSearchResult(){
            clearTimeout(this.queryTimeout)
            this.queryTimeout = setTimeout(async () => {
                this.page = 1
                this.searchTitle !== '' ? this.setSearchTitle() : this.placeholder = 'Search invoice number here ...'
                await this.retrieveReports()

            },300)
        },

        handleSearchEnterPressed(){
            if (!this.searchTitle){
                this.searchTitle= ''
                this.placeholder = 'Search invoice number here ...'
            }
            this.hideSearch()
        },

    },
    computed:{

    },

    watch:{

    },

    mounted() {

        this.retrieveTables()
        this.retrievePaymentType()
        this.retrieveSellers()
        this.retrieveCustomers()
        const vm = this


        /*=========Date Time Picker=========*/
        /*http://www.daterangepicker.com/*/
        $(function() {
            /* var start = moment().subtract(29, 'days');*/
            var start = moment().startOf('month');
            var end = moment().endOf('month');

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
                /*vm.getResults(vm.currentPage,(start.format('MMMM D, YYYY')), (end.format('MMMM D, YYYY')));*/
                vm.start = start.format('MMMM D, YYYY');
                vm.end = end.format('MMMM D, YYYY');
                vm.page = 1;
                vm.retrieveReports();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                    'All Times': [moment('2021-05-01T00:00:00.0000000Z'), moment()]
                },
                "showCustomRangeLabel": false,
                "alwaysShowCalendars": true,
                "opens": "right"
            }, cb);

            cb(start, end);
        });
        /*=========End of Date Time Picker=========*/


        /*Click search & pop-up*/
        let search_pop_up = $("#search-pop-up")
        $(document).ready(function()
        {
            let searchBlock = $("#search-block");
            searchBlock.click(function (){
                if (search_pop_up.hasClass('collapse')){
                    search_pop_up.removeClass('collapse')
                    search_pop_up.find('input').focus()
                }

            })
        });

        /*Click outside search pop-up then pop-up will close*/
        $(document).mouseup(function(e)
        {
            // if the target of the click isn't the container nor a descendant of the container
            if (!search_pop_up.is(e.target) && search_pop_up.has(e.target).length === 0)
            {
                search_pop_up.addClass('collapse')
            }
        });

        $(document).ready(function(){
            $('.card-body').overlayScrollbars({ overflowBehavior : {
                    x : "hidden",
                    y : "scroll"
                }, });
        });

    },
}
</script>

<style scoped>
table{
    margin-bottom: 0;
}

.table td, .table th {
    padding: 0.7rem;
}

.show-per-page{
    margin: 4px 0;
}
</style>


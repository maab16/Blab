<?php

namespace Blab\Libs;

	class Date{

		public function __construct(){

			$db = $db = DB::getInstance();
		}

		public static function getDate($date=''){

			return ($date)? $joined = explode('-', $joined_date) : '';

		}

		public static function getDayFromDate($date='' , $type=''){

			if (!$type=='' && !$date=='') {

				$date = explode('-', $date);
				$day = $date[2];

				switch ($type) {

					case 'BD':
					case 'bd':
					case 'Bd':
					case 'bD':

						if ($day ==1) {
					
							return $day = '১';
						}else if ($day ==2) {
							
							return $day = '২';
						}else if ($day ==3) {
							
							return $day = '৩';
						}else if ($day ==4) {
							
							return $day = '৪';
						}else if ($day ==5) {
							
							return $day = '৫';
						}else if ($day ==6) {
							
							return $day = '৬';
						}else if ($day ==7) {
							
							return $day = '৭';
						}else if ($day ==8) {
							
							return $day = '৮';
						}else if ($day ==9) {
							
							return $day = '৯';
						}else if ($day ==10) {
							
							return $day = '১০';
						}else if ($day ==11) {
							
							return $day = '১১';
						}else if ($day ==12) {
							
							return $day = '১২';
						}else if ($day ==13) {
							
							return $day = '১৩';
						}else if ($day ==14) {
							
							return $day = '১৪';
						}else if ($day ==15) {
							
							return $day = '১৫';
						}else if ($day ==16) {
							
							return $day = '১৬';
						}else if ($day ==17) {
							
							return $day = '১৭';
						}else if ($day ==18) {
							
							return $day = '১৮';
						}else if ($day ==19) {
							
							return $day = '১৯';
						}else if ($day ==20) {
							
							return $day = '২০';
						}else if ($day ==21) {
							
							return $day = '২১';
						}else if ($day ==22) {
							
							return $day = '২২';
						}else if ($day ==23) {
							
							return $day = '২৩';
						}else if ($day ==24) {
							
							return $day = '২৪';
						}else if ($day ==25) {
							
							return $day = '২৫';
						}else if ($day ==26) {
							
							return $day = '২৬';
						}else if ($day ==27) {
							
							return $day = '২৭';
						}else if ($day ==28) {
							
							return $day = '২৮';
						}else if ($day ==29) {
							
							return $day = '২৯';
						}else if ($day ==30) {
							
							return $day = '৩০';
						}else if ($day ==31) {
							
							return $day = '৩১';
						}
						
						break;

					case 'BN':
					case 'bn':
					case 'bN':
					case 'Bn':
						
						break;
					
					default:
						return $day;
						break;
				}
				
				
			}else if ($type=='' && !$date=='') {
				
				$date = explode('-', $date);
				return $date[2];
			}

			return '';

		}

		public static function getMonthFromDate($date='',$type=''){

			if (!$type=='' && !$date=='') {

				$date = explode('-', $date);
				$month = $date[1];

				switch ($type) {
					case 'EN':
					case 'eN':	
					case 'En':
					case 'en':					

						if ($month==1) {
									
							return $month = 'January';
						}else if ($month==2) {
										
							return $month = 'February';
						}else if ($month==3) {
										
							return $month = 'March';
						}else if ($month==4) {
										
							return $month = 'April';
						}else if ($month==5) {
										
							return $month = 'May';
						}else if ($month==6) {
										
							return $month = 'June';
						}else if ($month==7) {
										
							return $month = 'July';
						}else if ($month==8) {
										
							return $month = 'August';
						}else if ($month==9) {
										
							return $month = 'September';
						}else if ($month==10) {
										
							return $month = 'October';
						}else if ($month==11) {
										
							return $month = 'November';
						}else if ($month==2) {
										
							return $month = 'December';
						}
						break;

					case $type=='BN' || $type=='bn' || $type=='Bn' || $type=='bN':
						if ($month==1) {
							
							return $month = 'জানুয়ারি';
						}else if ($month==2) {
										
							return $month = 'ফেব্রুয়ারি';
						}else if ($month==3) {
										
							return $month = 'মার্চ';
						}else if ($month==4) {
										
							return $month = 'এপ্রিল';
						}else if ($month==5) {
										
							return $month = 'মে';
						}else if ($month==6) {
										
							return $month = 'জুন';
						}else if ($month==7) {
										
							return $month = 'জুলাই';
						}else if ($month==8) {
										
							return $month = 'আগস্ট';
						}else if ($month==9) {
										
							return $month = 'সেপ্টেম্বার';
						}else if ($month==10) {
										
							return $month = 'অক্টোবার';
						}else if ($month==11) {
										
							return $month = 'নভেমবার';
						}else if ($month==2) {
										
							return $month = 'ডিসেমবার';
						}
						break;

					default:
						return $month = $date[1];
						break;
				}

				
			}else if ($type=='' && !$date=='') {

					$date = explode('-', $date);
					return $month = $date[1];
					
				}
			

			return '';

		}

		public static function getYearFromDate($date='',$type=''){

			if (!$date=='' && !$type=='') {
				
				$date = explode('-', $date);

				$year = $date[0];

				switch ($type) {
					case 'B':
					case 'b':
						if ($year==2015) {
					
							return $year ='২০১৫' ;
						}else if ($year==2016) {
							
							return $year ='২০১৬' ;
						}else if ($year==2017) {
							
							return $year ='২০১৭' ;
						}else if ($year==2018) {
							
							return $year ='২০১৮' ;
						}else if ($year==2019) {
							
							return $year ='২০১৯' ;
						}else if ($year==2020) {
							
							return $year ='২০২০' ;
						}else if ($year==2021) {
							
							return $year ='২০২১' ;
						}else if ($year==2022) {
							
							return $year ='২০২২' ;
						}else if ($year==2023) {
							
							return $year ='২০২৩' ;
						}else if ($year==2024) {
							
							return $year ='২০২৪' ;
						}else if ($year==2025) {
							
							return $year ='২০২৫' ;
						}else if ($year==2026) {
							
							return $year ='২০২৬' ;
						}else if ($year==2027) {
							
							return $year ='২০২৭' ;
						}else if ($year==2028) {
							
							return $year = '২০২৮';
						}else if ($year==2029) {
							
							return $year = '২০২৯';
						}else if ($year==2030) {
							
							return $year = '২০৩০';
						}
						break;

					case 'E':
					case 'e':
						return $year;
						break;
					
					default:
						return $year;
						break;
				}
			}else if(!$date=='' && $type==''){

				$date = explode('-', $date);

				return $year = $date[0];

			}

			return '';

		}
		
	}
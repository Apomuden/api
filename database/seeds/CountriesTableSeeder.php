<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('truncate table countries');

        $sql = "INSERT INTO `countries` (`id`, `country_name`, `country_code`, `call_code`, `currency`, `status`, `created_at`, `updated_at`) VALUES
        (1, 'Afghanistan', 'AF', '+93', 'AFN', 'ACTIVE', '2019-04-30 12:13:13', '2019-04-30 12:13:13'),
        (2, 'Aland Islands', '	AX', '+358', 'EUR', 'ACTIVE', '2019-04-30 12:13:13', '2019-04-30 12:13:13'),
        (3, 'Albania', 'AL', '+355', 'ALL', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (4, 'Algeria', 'DZ', '+213', 'DZD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (5, 'American Samoa', 'AS', '+1684', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (6, 'Andorra', 'AD', '+376', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (7, 'Angola', 'AO', '+244', 'AOA', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (8, 'Anguilla', 'AI', '+1264', 'XCD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (9, 'Antarctica', 'AQ', '+672', '', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (10, 'Antigua And Barbuda', 'AG', '+1268', 'XCD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (11, 'Argentina', 'AR', '+54', 'ARS', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (12, 'Armenia', 'AM', '+374', 'AMD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (13, 'Aruba', 'AW', '+297', 'AWG', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (14, 'Australia', 'AU', '+61', 'AUD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (15, 'Austria', 'AT', '+43', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (16, 'Azerbaijan', 'AZ', '+994', 'AZN', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (17, 'Bahamas The', 'BS', '+1242', 'BSD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (18, 'Bahrain', 'BH', '+973', 'BHD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (19, 'Bangladesh', 'BD', '+880', 'BDT', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (20, 'Barbados', 'BB', '+1246', 'BBD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (21, 'Belarus', 'BY', '+375', 'BYR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (22, 'Belgium', 'BE', '+32', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (23, 'Belize', 'BZ', '+501', 'BZD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (24, 'Benin', 'BJ', '+229', 'XOF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (25, 'Bermuda', 'BM', '+1441', 'BMD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (26, 'Bhutan', 'BT', '+975', 'BTN', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (27, 'Bolivia', 'BO', '+591', 'BOB', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (28, 'Bosnia and Herzegovina', 'BA', '+387', 'BAM', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (29, 'Botswana', 'BW', '+267', 'BWP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (30, 'Bouvet Island', 'BV', '', 'NOK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (31, 'Brazil', 'BR', '+55', 'BRL', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (32, 'British Indian Ocean Territory', 'IO', '+246', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (33, 'Brunei', 'BN', '+673', 'BND', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (34, 'Bulgaria', 'BG', '+359', 'BGN', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (35, 'Burkina Faso', 'BF', '+226', 'XOF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (36, 'Burundi', 'BI', '+257', 'BIF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (37, 'Cambodia', 'KH', '+855', 'KHR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (38, 'Cameroon', 'CM', '+237', 'XAF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (39, 'Canada', 'CA', '+1', 'CAD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (40, 'Cape Verde', 'CV', '+238', 'CVE', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (41, 'Cayman Islands', 'KY', '+1345', 'KYD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (42, 'Central African Republic', 'CF', '+236', 'XAF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (43, 'Chad', 'TD', '+235', 'XAF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (44, 'Chile', 'CL', '+56', 'CLP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (45, 'China', 'CN', '+86', 'CNY', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (46, 'Christmas Island', 'CX', '+61', 'AUD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (47, 'Cocos (Keeling) Islands', 'CC', '+61', 'AUD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (48, 'Colombia', 'CO', '+57', 'COP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (49, 'Comoros', 'KM', '+269', 'KMF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (50, 'Congo', 'CG', '+242', 'XAF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (51, 'Congo The Democratic Republic Of The', 'CD', '+243', 'CDF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (52, 'Cook Islands', 'CK', '+682', 'NZD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (53, 'Costa Rica', 'CR', '+506', 'CRC', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (54, 'Cote D\'Ivoire (Ivory Coast)', 'CI', '+225', 'XOF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (55, 'Croatia (Hrvatska)', 'HR', '+385', 'HRK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (56, 'Cuba', 'CU', '+53', 'CUP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (57, 'Cyprus', 'CY', '+357', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (58, 'Czech Republic', 'CZ', '+420', 'CZK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (59, 'Denmark', 'DK', '+45', 'DKK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (60, 'Djibouti', 'DJ', '+253', 'DJF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (61, 'Dominica', 'DM', '+1767', 'XCD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (62, 'Dominican Republic', 'DO', '+1809 and 1829', 'DOP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (63, 'East Timor', 'TL', '+670', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (64, 'Ecuador', 'EC', '+593', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (65, 'Egypt', 'EG', '+20', 'EGP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (66, 'El Salvador', 'SV', '+503', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (67, 'Equatorial Guinea', 'GQ', '+240', 'XAF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (68, 'Eritrea', 'ER', '+291', 'ERN', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (69, 'Estonia', 'EE', '+372', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (70, 'Ethiopia', 'ET', '+251', 'ETB', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (71, 'Falkland Islands', 'FK', '+500', 'FKP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (72, 'Faroe Islands', 'FO', '+298', 'DKK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (73, 'Fiji Islands', 'FJ', '+679', 'FJD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (74, 'Finland', 'FI', '+358', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (75, 'France', 'FR', '+33', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (76, 'French Guiana', 'GF', '+594', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (77, 'French Polynesia', 'PF', '+689', 'XPF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (78, 'French Southern Territories', 'TF', '', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (79, 'Gabon', 'GA', '+241', 'XAF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (80, 'Gambia The', 'GM', '+220', 'GMD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (81, 'Georgia', 'GE', '+995', 'GEL', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (82, 'Germany', 'DE', '+49', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (83, 'Ghana', 'GH', '+233', 'GHS', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (84, 'Gibraltar', 'GI', '+350', 'GIP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (85, 'Greece', 'GR', '+30', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (86, 'Greenland', 'GL', '+299', 'DKK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (87, 'Grenada', 'GD', '+1473', 'XCD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (88, 'Guadeloupe', 'GP', '+590', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (89, 'Guam', 'GU', '+1671', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (90, 'Guatemala', 'GT', '+502', 'GTQ', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (91, 'Guernsey and Alderney', 'GG', '+441481', 'GBP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (92, 'Guinea', 'GN', '+224', 'GNF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (93, 'Guinea-Bissau', 'GW', '+245', 'XOF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (94, 'Guyana', 'GY', '+592', 'GYD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (95, 'Haiti', 'HT', '+509', 'HTG', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (96, 'Heard and McDonald Islands', 'HM', '', 'AUD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (97, 'Honduras', 'HN', '+504', 'HNL', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (98, 'Hong Kong S.A.R.', 'HK', '+852', 'HKD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (99, 'Hungary', 'HU', '+36', 'HUF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (100, 'Iceland', 'IS', '+354', 'ISK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (101, 'India', 'IN', '+91', 'INR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (102, 'Indonesia', 'ID', '+62', 'IDR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (103, 'Iran', 'IR', '+98', 'IRR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (104, 'Iraq', 'IQ', '+964', 'IQD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (105, 'Ireland', 'IE', '+353', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (106, 'Israel', 'IL', '+972', 'ILS', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (107, 'Italy', 'IT', '+39', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (108, 'Jamaica', 'JM', '+1876', 'JMD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (109, 'Japan', 'JP', '+81', 'JPY', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (110, 'Jersey', 'JE', '+441534', 'GBP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (111, 'Jordan', 'JO', '+962', 'JOD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (112, 'Kazakhstan', 'KZ', '+7', 'KZT', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (113, 'Kenya', 'KE', '+254', 'KES', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (114, 'Kiribati', 'KI', '+686', 'AUD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (115, 'Korea North\n', 'KP', '+850', 'KPW', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (116, 'Korea South', 'KR', '+82', 'KRW', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (117, 'Kuwait', 'KW', '+965', 'KWD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (118, 'Kyrgyzstan', 'KG', '+996', 'KGS', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (119, 'Laos', 'LA', '+856', 'LAK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (120, 'Latvia', 'LV', '+371', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (121, 'Lebanon', 'LB', '+961', 'LBP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (122, 'Lesotho', 'LS', '+266', 'LSL', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (123, 'Liberia', 'LR', '+231', 'LRD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (124, 'Libya', 'LY', '+218', 'LYD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (125, 'Liechtenstein', 'LI', '+423', 'CHF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (126, 'Lithuania', 'LT', '+370', 'LTL', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (127, 'Luxembourg', 'LU', '+352', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (128, 'Macau S.A.R.', 'MO', '+853', 'MOP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (129, 'Macedonia', 'MK', '+389', 'MKD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (130, 'Madagascar', 'MG', '+261', 'MGA', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (131, 'Malawi', 'MW', '+265', 'MWK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (132, 'Malaysia', 'MY', '+60', 'MYR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (133, 'Maldives', 'MV', '+960', 'MVR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (134, 'Mali', 'ML', '+223', 'XOF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (135, 'Malta', 'MT', '+356', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (136, 'Man (Isle of)', 'IM', '+441624', 'GBP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (137, 'Marshall Islands', 'MH', '+692', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (138, 'Martinique', 'MQ', '+596', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (139, 'Mauritania', 'MR', '+222', 'MRO', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (140, 'Mauritius', 'MU', '+230', 'MUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (141, 'Mayotte', 'YT', '+262', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (142, 'Mexico', 'MX', '+52', 'MXN', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (143, 'Micronesia', 'FM', '+691', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (144, 'Moldova', 'MD', '+373', 'MDL', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (145, 'Monaco', 'MC', '+377', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (146, 'Mongolia', 'MN', '+976', 'MNT', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (147, 'Montenegro', 'ME', '+382', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (148, 'Montserrat', 'MS', '+1664', 'XCD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (149, 'Morocco', 'MA', '+212', 'MAD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (150, 'Mozambique', 'MZ', '+258', 'MZN', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (151, 'Myanmar', 'MM', '+95', 'MMK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (152, 'Namibia', 'NA', '+264', 'NAD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (153, 'Nauru', 'NR', '+674', 'AUD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (154, 'Nepal', 'NP', '+977', 'NPR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (155, 'Netherlands Antilles', 'AN', '', '', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (156, 'Netherlands The', 'NL', '+31', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (157, 'New Caledonia', 'NC', '+687', 'XPF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (158, 'New Zealand', 'NZ', '+64', 'NZD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (159, 'Nicaragua', 'NI', '+505', 'NIO', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (160, 'Niger', 'NE', '+227', 'XOF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (161, 'Nigeria', 'NG', '+234', 'NGN', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (162, 'Niue', 'NU', '+683', 'NZD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (163, 'Norfolk Island', 'NF', '+672', 'AUD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (164, 'Northern Mariana Islands', 'MP', '+1670', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (165, 'Norway', 'NO', '+47', 'NOK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (166, 'Oman', 'OM', '+968', 'OMR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (167, 'Pakistan', 'PK', '+92', 'PKR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (168, 'Palau', 'PW', '+680', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (169, 'Palestinian Territory Occupied', 'PS', '+970', 'ILS', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (170, 'Panama', 'PA', '+507', 'PAB', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (171, 'Papua new Guinea', 'PG', '+675', 'PGK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (172, 'Paraguay', 'PY', '+595', 'PYG', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (173, 'Peru', 'PE', '+51', 'PEN', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (174, 'Philippines', 'PH', '+63', 'PHP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (175, 'Pitcairn Island', 'PN', '+870', 'NZD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (176, 'Poland', 'PL', '+48', 'PLN', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (177, 'Portugal', 'PT', '+351', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (178, 'Puerto Rico', 'PR', '+1787 and 1939', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (179, 'Qatar', 'QA', '+974', 'QAR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (180, 'Reunion', 'RE', '+262', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (181, 'Romania', 'RO', '+40', 'RON', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (182, 'Russia', 'RU', '+7', 'RUB', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (183, 'Rwanda', 'RW', '+250', 'RWF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (184, 'Saint Helena', 'SH', '+290', 'SHP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (185, 'Saint Kitts And Nevis', 'KN', '+1869', 'XCD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (186, 'Saint Lucia', 'LC', '+1758', 'XCD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (187, 'Saint Pierre and Miquelon', 'PM', '+508', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (188, 'Saint Vincent And The Grenadines', 'VC', '+1784', 'XCD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (189, 'Saint-Barthelemy', 'BL', '+590', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (190, 'Saint-Martin (French part)', 'MF', '+590', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (191, 'Samoa', 'WS', '+685', 'WST', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (192, 'San Marino', 'SM', '+378', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (193, 'Sao Tome and Principe', 'ST', '+239', 'STD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (194, 'Saudi Arabia', 'SA', '+966', 'SAR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (195, 'Senegal', 'SN', '+221', 'XOF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (196, 'Serbia', 'RS', '+381', 'RSD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (197, 'Seychelles', 'SC', '+248', 'SCR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (198, 'Sierra Leone', 'SL', '+232', 'SLL', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (199, 'Singapore', 'SG', '+65', 'SGD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (200, 'Slovakia', 'SK', '+421', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (201, 'Slovenia', 'SI', '+386', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (202, 'Solomon Islands', 'SB', '+677', 'SBD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (203, 'Somalia', 'SO', '+252', 'SOS', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (204, 'South Africa', 'ZA', '+27', 'ZAR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (205, 'South Georgia', 'GS', '', 'GBP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (206, 'South Sudan', 'SS', '+211', 'SSP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (207, 'Spain', 'ES', '+34', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (208, 'Sri Lanka', 'LK', '+94', 'LKR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (209, 'Sudan', 'SD', '+249', 'SDG', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (210, 'Suriname', 'SR', '+597', 'SRD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (211, 'Svalbard And Jan Mayen Islands', 'SJ', '+47', 'NOK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (212, 'Swaziland', 'SZ', '+268', 'SZL', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (213, 'Sweden', 'SE', '+46', 'SEK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (214, 'Switzerland', 'CH', '+41', 'CHF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (215, 'Syria', 'SY', '+963', 'SYP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (216, 'Taiwan', 'TW', '+886', 'TWD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (217, 'Tajikistan', 'TJ', '+992', 'TJS', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (218, 'Tanzania', 'TZ', '+255', 'TZS', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (219, 'Thailand', 'TH', '+66', 'THB', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (220, 'Togo', 'TG', '+228', 'XOF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (221, 'Tokelau', 'TK', '+690', 'NZD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (222, 'Tonga', 'TO', '+676', 'TOP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (223, 'Trinidad And Tobago', 'TT', '+1868', 'TTD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (224, 'Tunisia', 'TN', '+216', 'TND', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (225, 'Turkey', 'TR', '+90', 'TRY', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (226, 'Turkmenistan', 'TM', '+993', 'TMT', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (227, 'Turks And Caicos Islands', 'TC', '+1649', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (228, 'Tuvalu', 'TV', '+688', 'AUD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (229, 'Uganda', 'UG', '+256', 'UGX', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (230, 'Ukraine', 'UA', '+380', 'UAH', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (231, 'United Arab Emirates', 'AE', '+971', 'AED', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (232, 'United Kingdom', 'GB', '+44', 'GBP', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (233, 'United States', 'US', '+1', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (234, 'United States Minor Outlying Islands', 'UM', '+1', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (235, 'Uruguay', 'UY', '+598', 'UYU', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (236, 'Uzbekistan', 'UZ', '+998', 'UZS', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (237, 'Vanuatu', 'VU', '+678', 'VUV', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (238, 'Vatican City State (Holy See)', 'VA', '+379', 'EUR', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (239, 'Venezuela', 'VE', '+58', 'VEF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (240, 'Vietnam', 'VN', '+84', 'VND', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (241, 'Virgin Islands (British)', 'VG', '+1284', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (242, 'Virgin Islands (US)', 'VI', '+1340', 'USD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (243, 'Wallis And Futuna Islands', 'WF', '+681', 'XPF', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (244, 'Western Sahara', 'EH', '+212', 'MAD', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (245, 'Yemen', 'YE', '+967', 'YER', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (246, 'Zambia', 'ZM', '+260', 'ZMK', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26'),
        (247, 'Zimbabwe', 'ZW', '+263', 'ZWL', 'ACTIVE', '2019-05-01 20:34:26', '2019-05-01 20:34:26');";

        DB::statement($sql);
    }
}

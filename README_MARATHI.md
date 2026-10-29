# Digital QR-Based Menu & Food Ordering System

हा beginner-friendly TY B.Sc. Computer Science mini project आहे. हा PHP + MySQL वापरतो आणि XAMPP वर local computer मध्ये चालतो.

## आवश्यक software
1. XAMPP (Apache आणि MySQL)
2. Browser (Chrome)
3. VS Code (किंवा Notepad)
4. Git (GitHub वर upload करायचे असल्यास)

## A. Project setup (पहिल्यांदा)
1. XAMPP install करा.
2. XAMPP Control Panel उघडा आणि **Apache** व **MySQL** समोर Start क्लिक करा.
3. हा ZIP extract करा.
4. Extract केलेला `QR_Menu_Food_Ordering_System` folder copy करा.
5. तो `C:\xampp\htdocs\` मध्ये paste करा. Final path असा असावा:
   `C:\xampp\htdocs\QR_Menu_Food_Ordering_System`
6. Browser मध्ये उघडा: `http://localhost/phpmyadmin`
7. वरच्या **Import** tab मध्ये जा, `database.sql` file निवडा आणि **Import** क्लिक करा.
8. आता हे उघडा: `http://localhost/QR_Menu_Food_Ordering_System/admin/setup.php`
9. Setup success दिसल्यावर admin login करा:
   - Username: `admin`
   - Password: `Admin@123`
10. Customer menu: `http://localhost/QR_Menu_Food_Ordering_System/`

## B. Project कसा वापरायचा
- Customer page वर food items दिसतील.
- Quantity निवडा, Add to Cart करा, cart मध्ये items तपासा.
- नाव आणि table number भरून Place Order करा.
- Admin login करून orders पाहा, status बदलू शकता.
- Menu Management मध्ये food items add/delete करू शकता.

## C. QR code
1. Customer menu चा URL घ्या: `http://localhost/QR_Menu_Food_Ordering_System/`
2. हा URL QR code generator मध्ये टाका आणि QR code डाउनलोड करा.
3. लक्षात ठेवा: `localhost` QR code फक्त त्याच laptop वर चालेल. दुसऱ्या mobile वरून scan करायचा असल्यास app public hosting वर deploy करावी किंवा त्याच Wi-Fi network मधील laptop चा reachable IP वापरावा. College demo साठी laptop वर menu open करून QR code चा concept explain करू शकता.

## D. महत्त्वाच्या सूचना
- हा educational demo आहे; production restaurant system नाही.
- Admin login केल्यानंतर `admin/setup.php` file delete करा किंवा rename करा.
- `db.php` मध्ये तुमच्या MySQL credentials नुसार बदल करा.
- Online payment integration समाविष्ट नाही.
- GitHub वर upload करण्यापूर्वी `db.php` मधील real passwords/credentials कधीही commit करू नका.

## E. GitHub वर upload (manual)
1. GitHub.com वर sign in करा.
2. New repository क्लिक करा; नाव `qr-menu-food-ordering-system` ठेवा.
3. Public/Private निवडा आणि Create repository करा.
4. Git installed असेल तर terminal मध्ये project folder उघडा आणि:
   ```
   git init
   git add .
   git commit -m "Initial mini project"
   git branch -M main
   git remote add origin https://github.com/YOUR-USERNAME/qr-menu-food-ordering-system.git
   git push -u origin main
   ```
5. `YOUR-USERNAME` तुमच्या GitHub username ने बदला. GitHub sign-in/permission विचारल्यास complete करा.
6. Git command वापरता येत नसेल तर repository page वर **Add file > Upload files** वापरा.

## F. Troubleshooting
- Apache start होत नसेल: port 80 conflict असू शकतो.
- MySQL start होत नसेल: XAMPP मध्ये MySQL start करा; आधीपासून दुसरा MySQL service चालू आहे का तपासा.
- `Unknown database`: `database.sql` phpMyAdmin मधून import झाले आहे का तपासा.
- DB connection error: `db.php` मध्ये host/user/password तपासा. Default XAMPP साधारणपणे user `root`, password रिकामा असतो.
- Blank page/error: Apache आणि MySQL सुरू आहेत का, URL/path बरोबर आहे का तपासा.

## G. Submission checklist
- [ ] Application runs locally
- [ ] Customer menu screenshot
- [ ] Cart/order confirmation screenshot
- [ ] Admin login screenshot
- [ ] Admin orders screenshot
- [ ] Test case results filled in
- [ ] GitHub repository link added to report
- [ ] Report and presentation reviewed

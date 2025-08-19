<p align="center">
  <img src="https://raw.githubusercontent.com/hacker-hub8/qurik/refs/heads/main/assets/qurik.png" alt="Quirk Logo" width="200"/>
</p>

<h1 align="center">Quirk – The Smartest Shield for Your Website 🛡️</h1>

<p align="center">
  Quirk is a powerful website security application that protects your site from <b>hackers, SQLi attacks, XSS vulnerabilities, spammers, bots, proxy visitors</b> and much more.  
  <br>
  <i>"Secure your web applications with industrial-strength algorithms, real-time monitoring, and intelligent pattern recognition."</i>
</p>

---

## 📖 Description  

Quirk is designed to defend websites from a wide variety of cyber threats including **SQL injection (SQLi), XSS attacks, spam bots, proxy users, and zero-day exploits**.  

It uses **intelligent algorithms** (similar to those used by industry-leading companies) to recognize known and unknown attack patterns and take automatic protective action.  

The platform comes with a **powerful Admin Panel**, giving full control over:  
- Security settings  
- Threat logs  
- Ban system (IPs, Countries, OS, Browsers, ISPs)  
- .htaccess editor  
- Error monitoring  
- Visitor analytics  

Quirk provides **real-time monitoring**, detailed attack logs, email alerts, and tools to continuously secure your website.  

---

## ✨ Features  

- **SQLi & XSS Protection** – Detects and blocks SQL injections and cross-site scripting attacks.  
- **Proxy & VPN Protection** – Restricts access from proxies, VPNs, and TOR.  
- **Spam Protection** – Identifies and blocks spam bots & malicious requests.  
- **Input Sanitization** – Filters requests/responses to prevent injections.  
- **Bad Words & Content Filtering** – Real-time filtering of profanity, malicious links & content.  
- **DNSBL Integration** – Connects with global spam databases for maximum protection.  
- **Intelligent Pattern Recognition** – Detects unknown & zero-day threats.  
- **Ban System** – Block users by IP, country, OS, browser, ISP, etc.  
- **Bot & Crawler Protection** – Verifies and filters fake/unauthorized bots.  
- **Header Checks** – Validates visitor request headers.  
- **Real-Time Scanning** – Scans all GET, POST & other request types.  
- **Auto Ban** – Automatically blocks bad actors.  
- **Detailed Threat Logs** – Stores attack details (location, OS, browser, user-agent, etc.).  
- **IP Lookup Tool** – Investigate suspicious IP addresses.  
- **Email Notifications** – Alerts on attack detection.  
- **Admin Dashboard** – Real-time stats, logs & activity visualization.  
- **.htaccess Editor** – Modify rules directly from the dashboard.  
- **Error Monitoring** – Capture and track server/application errors.  
- **Whitelist Support** – Safelist specific IPs and files.  
- **Live Traffic Monitoring** – View visitors in real time.  
- **Visit Analytics** – Analyze how users interact with your site.  
- **PHP & System Info** – Scan server configuration for potential flaws.  
- **Optimized & Lightweight** – Minimal performance impact.  
- **Responsive UI** – Works across devices with AdminLTE-based dashboard.  
- **Easy Setup** – Installation wizard + simple integration.  

---

## 🛠️ Requirements  

- **PHP** (≥7.4 recommended)  
- **MySQL Database**  
- **Apache/Nginx server** with `.htaccess` support  

---

## ⚡ Installation & Integration  

1. **Upload Quirk:**  
   Create a subfolder named `qurik` under your website’s root directory (`www` / `public_html`).  

2. **Copy Files:**  
   Upload all files from the **Source** folder into the `qurik` subfolder.  

3. **Set Permissions:**  
   Change permissions of the `qurik` folder and its files to `CHMOD 777`.  

4. **Create Database:**  
   Create a new MySQL database (your hosting provider can help).  

5. **Run Installer:**  
   Open your browser and go to:  

Got it 👍 Here’s the **final polished README.md file** with exactly what you want (including your integration code, project structure, sources/credits, community, license, and footer).

```markdown
# Quirk – Web Security Platform

## 🚀 Installation

1. Upload the **qurik/** folder to your website root directory.  
2. Visit:  

```

yourwebsite.com/qurik

````

3. The **Installation Wizard** will launch – follow the steps.  

4. **Integration Code:**  
At the end of setup, copy the integration code and add it into your main PHP file (e.g., `index.php`):  

```php
include "qurik/config.php";
include "qurik/qurik-security.php";
````

✅ Done 🎉 – Your website is now secured by Quirk.

🔄 **Updating:** Replace all files except `qurik-security.php`. If issues occur, delete `config.php` and reinstall.

---

## 📂 Project Structure

```
qurik/
 ├── assets/            # CSS, JS, Images, Fonts
 ├── includes/          # Header, footer, meta includes
 ├── pages/             # About, contact, policies, team, etc.
 ├── logs/              # Stored security and error logs
 ├── index.php          # Main entry point
 ├── config.php         # Configuration file
 ├── qurik-security.php # Core security logic
 └── .htaccess          # Apache rules
```

---

## 📜 Sources & Credits

* **Font Awesome** – Icons
* **Bootstrap** – CSS Framework
* **DataTables** – Interactive tables
* **jQuery** – JavaScript utilities
* **AdminLTE** – Dashboard UI
* **Select2** – Advanced dropdowns
* **OpenLayers** – Maps
* **Chart.js** – Graphs & charts
* **Flag Sprites** – Country flags
* **ip.nf / ipapi / IPHub** – IP lookup APIs
* **ProxyCheck.io / IPHunter** – Proxy detection APIs
* **Switchery** – UI switches
* **Popper.js** – Tooltips & popovers
* **OverlayScrollbars** – Custom scrollbars

---

## 🌍 Community & Support

💬 Join the discussion, suggest features, and report bugs via **Issues & Pull Requests**.
🙌 Contributions are welcome to make Quirk stronger and smarter.

---

## 📜 License

This project is licensed under the **MIT License** 

---

<p align="center">Made with ❤️ by <b>Anup Ganiger</b> | <a href="https://hackerhub8.in/me">HackerHub8</a></p>



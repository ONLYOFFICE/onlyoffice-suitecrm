# ONLYOFFFICE add-on for SuiteCRM

The ONLYOFFICE add-on for SuiteCRM integrates [ONLYOFFICE Docs](https://www.onlyoffice.com/docs) into your [SuiteCRM](https://suitecrm.com) platform, enabling seamless work with office files directly within the system.

<p align="center">
  <a href="https://www.onlyoffice.com/office-for-suitecrm">
    <img width="800" src="https://static-site.onlyoffice.com/public/images/templates/office-for-suitecrm/hero/screen5@2x.png" alt="ONLYOFFICE Docs for SuiteCRM">
  </a>
</p>

## ✨ Functionality

- **Work with documents, spreadsheets, and presentations:** View, edit and manage files attached to CRM records or stored in the Documents module.
- **Real-time collaboration:** Work with colleagues simultaneously on any document, with two co-editing modes (Fast and Strict), track changes, and built-in commenting features.
- **Secure editing:** JSON Web Token (JWT) is used to secure all document traffic and prevent unauthorized access and prevent unauthorized access.

### Supported file formats

- **View/Edit:** DOCX, XLSX, PPTX.
- **View:** PDF, ODT, ODS, ODP, DOC, XLS, PPT, PPS, EPUB, RTF, HTML, HTM, TXT, CSV.

## Ready to integrate? Here's what you need

Before you begin, make sure your environment meets the following requirements:

| **Component**       | **Details**                                                                                       |
| :------------------ | :------------------------------------------------------------------------------------------------ |
| **ONLYOFFICE Docs** | Accessible instance of [ONLYOFFICE Docs](https://www.onlyoffice.com/docs) (online editors), preferably the latest stable version.    |
| **Connection**      | SuiteCRM must be able to communicate with ONLYOFFICE Docs and receive callback **POST** requests. |
| **SuiteCRM**        | Confirmed compatibility with the latest stable release of SuiteCRM.                               |

For deployment, choose between a self-hosted installation or the [ONLYOFFICE Docs Cloud](https://www.onlyoffice.com/docs-registration) service.

Installation options:
- [Install with Docker (recommended)](https://github.com/ONLYOFFICE/Docker-DocumentServer)
- [Install with DEB/RPM packages](https://helpcenter.onlyoffice.com/docs/installation/docs-community-install-ubuntu.aspx)
- [Install the Enterprise Edition](https://helpcenter.onlyoffice.com/docs/installation/enterprise)

Review the [ONLYOFFICE Docs Editions](#onlyoffice-docs-editions) section for more details on the self-hosted Community and Enterprise options.

## 🛠️ Installation

Follow the steps below to install the ONLYOFFICE add-on for SuiteCRM:

### Step 1: Download the add-on

Download the latest stable release (`.zip` file) from the [Releases page](https://github.com/ONLYOFFICE/onlyoffice-suitecrm/releases).

### Step 2: Install via Module Loader

1. Log into your SuiteCRM instance as an **Administrator**.
2. Navigate to **Admin** → **Admin Tools** → **Module Loader**.
3. Click **Browse**, select the downloaded ZIP file, and click **Upload**.
4. Once uploaded, click **Install** and confirm the installation.

### Step 3: Run Quick Repair and Rebuild

1. Navigate to **Admin** → **Admin Tools** → **Repair**.
2. Select **Quick Repair and Rebuild**.

## ⚙️ Configuration

After installation, configure the add-on for secure communication with ONLYOFFICE Docs.

1. Go to **Admin → ONLYOFFICE Settings**.
2. Enter the ONLYOFFICE Docs URL.
3. Set up JWT security:
   - Use the same secret key configured in your ONLYOFFICE Docs instance (`local.json` for self-hosted setups).
   - In SuiteCRM, go to **ONLYOFFICE Settings → Secret Key** and enter the same key.
   - Click **Save** to apply changes.

**Note:** JWT is enabled by default and a secret key is auto-generated. You may override it with a custom key—but if you do, use the same key in both systems.

📘Learn more about JWT security in the [official documentation](https://api.onlyoffice.com/docs/docs-api/additional-api/signature/).

## 📥 Using the add-on

Once the add-on is configured, you can view and edit documents directly in SuiteCRM:

1. Go to the **Documents** module.
2. Open the **Detail View** of a document by clicking its file name.
3. From the **Actions** menu, click **Open in ONLYOFFICE** — the file will open in a new tab for editing or real-time collaboration.
4. All changes are automatically saved back to SuiteCRM.

## ONLYOFFICE Docs editions

ONLYOFFICE offers different versions of its online document editors that can be deployed on your own servers.

**ONLYOFFICE Docs** packaged as Document Server:

* Community Edition 🆓 (`onlyoffice-documentserver` package)
* Enterprise Edition 🏢 (`onlyoffice-documentserver-ee` package)

The table below will help you to make the right choice.

| Pricing and licensing | Community Edition | Enterprise Edition |
| ------------- | ------------- | ------------- |
| | [Get it now](https://www.onlyoffice.com/download-community?utm_source=github&utm_medium=cpc&utm_campaign=GitHubSuiteCRM#docs-community)  | [Start Free Trial](https://www.onlyoffice.com/download?utm_source=github&utm_medium=cpc&utm_campaign=GitHubSuiteCRM#docs-enterprise)  |
| Cost  | FREE  | [Go to the pricing page](https://www.onlyoffice.com/docs-enterprise-prices?utm_source=github&utm_medium=cpc&utm_campaign=GitHubSuiteCRM)  |
| Simultaneous connections | up to 20 maximum  | As in chosen pricing plan |
| Number of users | up to 20 recommended | As in chosen pricing plan |
| License | GNU AGPL v.3 | Proprietary |
| **Support** | **Community Edition** | **Enterprise Edition** |
| Documentation | [Help Center](https://helpcenter.onlyoffice.com/docs/installation/community) | [Help Center](https://helpcenter.onlyoffice.com/docs/installation/enterprise) |
| Standard support | [GitHub](https://github.com/ONLYOFFICE/DocumentServer/issues) or paid | 1 or 3 years support included |
| Premium support | [Contact us](mailto:sales@onlyoffice.com) | [Contact us](mailto:sales@onlyoffice.com) |
| **Services** | **Community Edition** | **Enterprise Edition** |
| Conversion Service                | + | + |
| Document Builder Service          | + | + |
| **Interface** | **Community Edition** | **Enterprise Edition** |
| Tabbed interface                  | + | + |
| Dark theme                        | + | + |
| 125%, 150%, 175%, 200% scaling    | + | + |
| White Label                       | - | - |
| Integrated test example (node.js) | + | + |
| Mobile web editors                | - | +* |
| **Plugins & Macros** | **Community Edition** | **Enterprise Edition** |
| Plugins                           | + | + |
| Macros                            | + | + |
| **Collaborative capabilities** | **Community Edition** | **Enterprise Edition** |
| Two co-editing modes              | + | + |
| Comments                          | + | + |
| Built-in chat                     | + | + |
| Review and tracking changes       | + | + |
| Display modes of tracking changes | + | + |
| Version history                   | + | + |
| **Document Editor features** | **Community Edition** | **Enterprise Edition** |
| Font and paragraph formatting   | + | + |
| Object insertion                | + | + |
| Adding Content control          | + | + |
| Editing Content control         | + | + |
| Layout tools                    | + | + |
| Table of contents               | + | + |
| Navigation panel                | + | + |
| Mail Merge                      | + | + |
| Comparing Documents             | + | + |
| **Spreadsheet Editor features** | **Community Edition** | **Enterprise Edition** |
| Font and paragraph formatting   | + | + |
| Object insertion                | + | + |
| Functions, formulas, equations  | + | + |
| Table templates                 | + | + |
| Pivot tables                    | + | + |
| Data validation                 | + | + |
| Conditional formatting          | + | + |
| Sparklines                      | + | + |
| Sheet Views                     | + | + |
| **Presentation Editor features** | **Community Edition** | **Enterprise Edition** |
| Font and paragraph formatting   | + | + |
| Object insertion                | + | + |
| Transitions                     | + | + |
| Animations                      | + | + |
| Presenter mode                  | + | + |
| Notes                           | + | + |
| **Form creator features** | **Community Edition** | **Enterprise Edition** |
| Adding form fields              | + | + |
| Form preview                    | + | + |
| Saving as PDF                   | + | + |
| **PDF Editor features**      | **Community Edition** | **Enterprise Edition** |
| Text editing and co-editing                                | + | + |
| Work with pages (adding, deleting, rotating)               | + | + |
| Inserting objects (shapes, images, hyperlinks, etc.)       | + | + |
| Text annotations (highlight, underline, cross out, stamps) | + | + |
| Comments                        | + | + |
| Freehand drawings               | + | + |
| Form filling                    | + | + |
| | [Get it now](https://www.onlyoffice.com/download-community?utm_source=github&utm_medium=cpc&utm_campaign=GitHubSuiteCRM#docs-community)  | [Start Free Trial](https://www.onlyoffice.com/download?utm_source=github&utm_medium=cpc&utm_campaign=GitHubSuiteCRM#docs-enterprise)  |

\* If supported by DMS.

## Need help? User Feedback and Support 💡

* **🐞 Found a bug?** Please report it by creating an [issue](https://github.com/ONLYOFFICE/onlyoffice-suitecrm/issues).
* **❓ Have a question?** Ask our community and developers on the [ONLYOFFICE Forum](https://community.onlyoffice.com).
* **👨‍💻 Need help for developers?** Check our [API documentation](https://api.onlyoffice.com).
* **💡 Want to suggest a feature?** Share your ideas on our [feedback platform](https://feedback.onlyoffice.com/forums/966080-your-voice-matters).
# Agricultural Image Analysis API Prototype

A small integration prototype for submitting crop images to a Plantix image-analysis API and returning the API response through a simple web interface or Python client.

The repository is intended as a **technical proof of concept**, not as a production crop-diagnosis platform.

## What it demonstrates

- Third-party AI / computer-vision API integration
- File upload and multipart HTTP requests
- Python API client development
- PHP backend proxying
- Basic browser-based workflow
- Secure credential handling through environment variables
- Error handling and response inspection

## Architecture

```text
Browser UI
   |
   | image + crop
   v
API.php
   |
   | authenticated multipart request
   v
Plantix image-analysis API
   |
   v
JSON response
```

A standalone Python client (`identificar_cultivo.py`) is also included for testing or integration experiments.

## Security

API credentials are **not stored in source code**.

Configure the following environment variables on the machine or server running the prototype:

```bash
PLANTIX_API_TOKEN=your_token_here
PLANTIX_API_URL=https://api.plantix.net/v2/image_analysis
```

> Important: a credential was previously committed to this repository. It should be considered compromised and must be revoked/rotated by the credential owner. Removing it from the current files does not remove it from Git history.

## Python usage

Install the dependency:

```bash
pip install -r requirements.txt
```

Set your credentials and run:

```bash
python identificar_cultivo.py path/to/image.jpg coffee
```

## Web usage

Serve the repository through a PHP-capable web server, configure the environment variables for the server process, and open `index.html`.

The browser posts the selected image to `API.php`, which keeps the API token server-side.

## Files

- `index.html` — browser interface
- `styles.css` — presentation layer
- `API.php` — server-side API proxy
- `identificar_cultivo.py` — standalone Python client
- `.env.example` — environment-variable template
- `requirements.txt` — Python dependencies

## Portfolio context

This prototype reflects work at the intersection of **AI integration, APIs, agricultural technology and automation**. Its value is the integration pattern rather than a proprietary AI model: a user-facing workflow connects to an external AI service while credentials remain isolated on the server side.

## Limitations

- Requires valid credentials for the configured Plantix API.
- Supported crop identifiers and response schema depend on the external API.
- No persistence, authentication, rate limiting or production monitoring is implemented.
- This repository should be treated as a proof of concept.

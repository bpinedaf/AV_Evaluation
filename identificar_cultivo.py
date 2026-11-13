"""Minimal Plantix image-analysis client.

Credentials are read from environment variables. Never hardcode API tokens in source code.
"""

from __future__ import annotations

import argparse
import os
from pathlib import Path

import requests


DEFAULT_API_URL = "https://api.plantix.net/v2/image_analysis"


def identify_crop(image_path: str | Path, crop: str) -> dict:
    """Send an image and crop name to the configured Plantix image-analysis API."""
    token = os.getenv("PLANTIX_API_TOKEN")
    api_url = os.getenv("PLANTIX_API_URL", DEFAULT_API_URL)

    if not token:
        raise RuntimeError("PLANTIX_API_TOKEN is not set.")

    image_path = Path(image_path)
    if not image_path.is_file():
        raise FileNotFoundError(f"Image not found: {image_path}")

    headers = {
        "Accept": "application/json",
        "Authorization": f"Bearer {token}",
    }

    with image_path.open("rb") as image_file:
        files = {"image": image_file}
        data = {
            "crop": crop,
            "application_used_image_gallery": "false",
        }
        response = requests.post(
            api_url,
            headers=headers,
            files=files,
            data=data,
            timeout=30,
        )

    response.raise_for_status()
    return response.json()


def main() -> None:
    parser = argparse.ArgumentParser(description="Analyze a crop image using Plantix.")
    parser.add_argument("image", help="Path to the image file")
    parser.add_argument("crop", help="Crop identifier, e.g. coffee or corn")
    args = parser.parse_args()

    result = identify_crop(args.image, args.crop)
    print(result)


if __name__ == "__main__":
    main()

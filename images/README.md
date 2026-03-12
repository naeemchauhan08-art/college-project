# Library Wallpaper Setup Guide

## How to Add Your Library Wallpaper

### Step 1: Download a High-Quality Image
1. Visit free stock photo sites like:
   - [Unsplash](https://unsplash.com/s/photos/library-books)
   - [Pexels](https://www.pexels.com/search/library%20books/)
   - [Pixabay](https://pixabay.com/images/search/library%20books/)

2. Look for images with these characteristics:
   - **Resolution**: At least 1920x1080 pixels (Full HD)
   - **Orientation**: Landscape works best
   - **Subject**: Library shelves, books, or academic settings
   - **Quality**: Clear, professional photos

### Step 2: Save the Image
1. Save your chosen image in this `images` folder
2. Name it exactly: `library-bg.jpg`
3. Supported formats: `.jpg`, `.jpeg`, `.png`, `.webp`

### Step 3: Refresh Your Browser
- Press `Ctrl + F5` (Windows) or `Cmd + Shift + R` (Mac)
- The background should now appear behind all pages

## Troubleshooting

### Image Not Showing?
1. **Check the filename**: Must be exactly `library-bg.jpg`
2. **Verify the path**: Image must be in `sgj library/images/` folder
3. **Clear browser cache**: Press `Ctrl + F5`
4. **Check file permissions**: Ensure the image is readable

### Text Hard to Read?
The system uses a royal blue overlay (85% opacity) to ensure text readability. If you're still having issues:
1. Try a darker or less busy image
2. Avoid images with high contrast areas
3. Use images with muted colors

## Technical Details

### Current Configuration
```css
background-image: linear-gradient(rgba(30, 58, 138, 0.85), rgba(30, 58, 138, 0.85)), url('images/library-bg.jpg');
background-size: cover;
background-position: center;
background-attachment: fixed;
```

### What Each Setting Does
- **Gradient Overlay**: Royal blue with 85% opacity for text contrast
- **Cover**: Ensures image fills the entire screen
- **Center**: Keeps image centered on all screen sizes
- **Fixed**: Background stays in place while scrolling
- **No-repeat**: Prevents tiling on small screens

## Customization Options

### Adjust Overlay Opacity
Edit `style.css` and change the alpha value (0.85):
- More transparent: `0.70` to `0.80`
- More opaque: `0.90` to `0.95`

### Change Overlay Color
Modify the RGB values in the gradient:
- Current: `rgba(30, 58, 138, 0.85)` (Royal Blue)
- Darker: `rgba(10, 25, 60, 0.85)`
- Lighter: `rgba(50, 80, 150, 0.85)`

## Best Practices

### DO ✅
- Use high-resolution images (1920x1080 or higher)
- Choose images with consistent lighting
- Test on multiple devices
- Keep the image file size under 2MB for fast loading

### DON'T ❌
- Use low-resolution or pixelated images
- Choose overly bright or neon images
- Use images with text overlays
- Forget to optimize image file size

## Example Image Sources

Here are some direct links to great free options:

1. **Classic Library Shelves**
   - Search: "library bookshelves" on Unsplash
   
2. **Academic Setting**
   - Search: "university library" on Pexels
   
3. **Vintage Books**
   - Search: "old books library" on Pixabay

4. **Modern Library**
   - Search: "modern library interior" on Unsplash

---

**Need Help?**
If you encounter any issues, check your browser's developer console (F12) for error messages related to the image path.

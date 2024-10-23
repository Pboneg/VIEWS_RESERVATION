const multer = require('multer');

const cvStorage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, 'cvs/');
  },
  filename: (req, file, cb) => {
    const ext = file.originalname.split('.').pop();
    cb(null, `${Date.now()}.${ext}`);
  }
});

const uploadCV = multer({ storage: cvStorage });

app.post('/api/students/upload-cv', uploadCV.single('cv'), (req, res) => {
  const cvUrl = `${req.protocol}://${req.get('host')}/cvs/${req.file.filename}`;
  res.status(200).json({ cvUrl });
});

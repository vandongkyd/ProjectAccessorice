package com.example.khoavx.accessoriceshop.Utils;

import android.os.Handler;
import android.os.Looper;
import androidx.annotation.Nullable;

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;


import okhttp3.MediaType;
import okhttp3.RequestBody;
import okio.BufferedSink;

/**
 * Created by vandongluong on 10/21/18.
 */

public class ProgressRequestBody extends RequestBody {

    private File file;
    private static final int DEFAULT_BUFFER_SIZE = 4096;
    private UploadCallBack listener;

    public ProgressRequestBody(File file, UploadCallBack listener) {
        this.file = file;
        this.listener = listener;
    }

    @Override
    public long contentLength() throws IOException {
        return super.contentLength();
    }

    @Nullable
    @Override
    public MediaType contentType() {
        return MediaType.parse("image/*");
    }

    @Override
    public void writeTo(BufferedSink sink) throws IOException {
        long fileLenght = file.length();
        byte[] buffer = new byte[DEFAULT_BUFFER_SIZE];
        FileInputStream inp = new FileInputStream(file);
        long uploaded = 0;
        try{
            int read;
            Handler handler = new Handler(Looper.getMainLooper());
            while ((read = inp.read(buffer)) != -1){
                handler.post(new ProgressUpdater(uploaded,fileLenght));
                uploaded += read;
                sink.write(buffer,0,read);
            }
        }finally {
            inp.close();
        }
    }

    private class ProgressUpdater implements Runnable {
        private long uploaded, fileLength;
        public ProgressUpdater(long uploaded, long fileLenght) {
            this.uploaded = uploaded;
            this.fileLength = fileLenght;
        }

        @Override
        public void run() {
            listener.onProgressUpdate((int)(100*uploaded/fileLength));
        }
    }
}

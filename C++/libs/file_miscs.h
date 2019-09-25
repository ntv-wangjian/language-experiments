#ifndef FILE_MISCS_H
#define FILE_MISCS_H
#include <string.h>
#include <stdlib.h>
#include <errno.h>
#include <stdio.h>
#include <unistd.h>
#include <sys/stat.h> 

int FileWrite(const char *filename,const char* buf,int bufsize);
int FileAppend(const char* filename,const char* buf,int bufsize);
int FileRead(const char* filename,char* buf,int max_bufsize);
int FileDelete(const char* filename);
int IsFileExist(const char* filename);
int FileSize(const char* filename);
int DirCreate(const char* dir);
int DirCreateRecursion(const char* path);
int FileWriteText(const char* filename,const char* contenxt);
int FileIoWriteText(const char* txt,FILE *fpout);
int FileIoPrintf(FILE *fpout,const char *fmt, ...);

#endif
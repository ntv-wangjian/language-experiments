#include "file_miscs.h"

int FileWrite(const char *filename,const char* buf,int bufsize)
{
	FILE	*fp = NULL;
	if(NULL == filename || NULL == buf) {
		return -1;
	}
	fp = fopen(filename,"w");
	if(NULL == fp) {
		return -1;
	}
	fwrite(buf,1,bufsize,fp);
	fclose(fp);
	return 0;
}

int FileAppend(const char* filename,const char* buf,int bufsize)
{
	int	    ret = 0;
	FILE	*fp = NULL;
	if(NULL == filename || NULL == buf) {
		return -1;
	}
	fp = fopen(filename,"a+");
	if(NULL == fp) {
		return -1;
	}
	ret = fwrite(buf,1,bufsize,fp);
	fclose(fp);
	return 0;
}

int FileRead(const char* filename,char* buf,int max_bufsize)
{
	int      ret = 0;
	FILE	*fp = NULL;
	if(NULL == filename || NULL == buf) {
		return -1;
	}
	if(access(filename,0) != 0) {
		return -1;
	}
	fp = fopen(filename,"r");
	if(NULL == fp) {
		return -1;
	}
	ret = fread(buf,1,max_bufsize,fp);
	fclose(fp);
	return ret;
}

int FileDelete(const char* filename)
{
	int	ret = 0;
	if(NULL == filename) {
		return -1;
	}
	if(access(filename,0) != 0) {
		return 0;
	}
	ret = remove(filename);
	if(ret == 0) {
		return 0;
	}
	else {
		return -1;
	}
}

int IsFileExist(const char* filename)
{
	if(!filename || access(filename,0)!=0)
	{
		return 0;
	}
	return 1;
}

int FileSize(const char* filename)
{
	int size = 0;
	FILE *fp = NULL;
	if(NULL == filename) {
		return -1;
	}
	if(access(filename,0) != 0) {
		return -1;
	}
	fp = fopen(filename,"rb");
	if(fp) {
		fseek(fp,0,SEEK_END);
		size = ftell(fp);
		fclose(fp);
	}	
	return size;
}

int DirCreate(const char* dir){
	return mkdir(dir, 0755);
}

int DirCreateRecursion(const char* path)
{
	char cmd[512];
    if(access(path,0)!=0)
    {
        sprintf(cmd,"mkdir -p %s",path);
        return system(cmd);
    }

    return 0;
}

int FileWriteText(const char* filename,const char* contenxt)
{
	FILE* fp = fopen(filename,"w");
    if(fp==NULL) 
    {
        return -1;
    }
	fwrite(contenxt,1,strlen(contenxt),fp);
    fclose(fp);
	return 0;
}

int FileIoWriteText(const char* txt,FILE *fpout){
	if(NULL == fpout) {
		return 0;
	}
	return fwrite(txt,1,strlen(txt),fpout);
}

int FileIoPrintf(FILE *fpout,const char *fmt, ...){
	va_list ap;
    char buf[4096]; 
    int ret;

    va_start(ap, fmt);
    ret = vsnprintf(buf, sizeof(buf), fmt, ap);
    va_end(ap);

    return FileIoWriteText(buf,fpout);
}